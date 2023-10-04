<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Interfaces\UserInterface;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\UserCollection;
use App\Http\Requests\Admin\UserRequest;
use App\Http\Resources\ActiveUserCollection;

class UserController extends Controller
{
    protected $user;

    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        $perPage = request()->per_page;
        $fieldName = request()->field_name;
        $keyword = request()->keyword;

        $query = User::query()
            ->where($fieldName, 'LIKE', "%$keyword%")
            ->orderBy('id', 'asc')
            ->paginate($perPage);

        return new UserCollection($query);

        /* $user = $this->user->get();
         return response()->json($user);*/
    }

    public function deletedListIndex()
    {
        $user = $this->user->onlyTrashed();
        return response()->json($user);
    }

    public function store(UserRequest $request)
    {
        $data = $request;
        $data['employment_status'] = 'Admin';
        $data['is_admin'] = 'Yes';
        $data['password'] = Hash::make($request->password);

        // dd($data->all());
        $user = $this->user->create($data);

        return response()->json($user);
        // return new UserResource($user);
    }

    public function show(User $user)
    {
        $user = $this->user->findOrFail($user->id);
        return response()->json($user);
    }

    public function edit($id)
    {
        $user = $this->user->findOrFail($id);
        return response()->json($user);
    }

    public function update(UserRequest $request, User $user)
    {
        $data = $request;
        $data['employment_status'] = 'Admin';
        $data['is_admin'] = 'Yes';
        $data['password'] = Hash::make($request->password);
        $user = $this->user->update($user->id,$data);
        $request['update'] = 'update';
        return new UserResource($user);
    }

    public function destroy(User $user)
    {
        $this->user->delete($user->id);
        return response()->json([
            'message' => trans('user.deleted'),
        ], 200);
    }

    public function restore($id)
    {
        $this->user->restore($id);
        return response()->json([
            'message' => trans('user.restored'),
        ], 200);
    }

    public function forceDelete($id)
    {
        $this->user->forceDelete($id);
        return response()->json([
            'message' => trans('user.permanent_deleted'),
        ], 200);
    }

    public function status(Request $request)
    {
        $this->user->status($request->id);
        return response()->json([
            'message' => trans('user.status_updated'),
        ], 200);
    }

    public function systemUsers()
    {
        $users = User::query()->select('name','email','id')->get();

        return response()->json($users);
    }

    public function activeUsers() {
        $perPage = request()->per_page;
        $fieldName = request()->field_name;
        $keyword = request()->keyword;

        $users = User::query()
            ->whereNotNull('last_seen')
            ->where($fieldName, 'LIKE', "%$keyword%")
            ->orderBy('last_seen', 'DESC')
            ->paginate($perPage);

        $users->map(function ($user) {
            $isActive = Cache::has('user-is-online-' . $user->id);
            $user->active = $isActive;
            return $user;
        });

        // $activeUserCount = $users->where('active', true)->count();

        return new ActiveUserCollection($users);
    }

    public function todayUserLogins()
    {
        $today = Carbon::today();

        $userLogins = DB::table('personal_access_tokens')
            ->whereDate('created_at', $today)
            ->distinct('tokenable_id')
            ->count();

        return response()->json(['count' => $userLogins]);
    }

    public function userLoginsPerDay()
    {
        $userLogins = DB::table('personal_access_tokens')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(DISTINCT tokenable_id) as count'))
            ->groupBy('date')
            ->get();

        return response()->json($userLogins);
    }

    public function averageUserLoginsPerDay()
    {
        $averageUserLogins = DB::table('personal_access_tokens')
        ->select(DB::raw('COUNT(DISTINCT tokenable_id) as count'), DB::raw('COUNT(DISTINCT DATE(created_at)) as date'))
        ->first();

        $average = $averageUserLogins->count / $averageUserLogins->date;

        return response()->json(['average' => $average]);
    }
}
