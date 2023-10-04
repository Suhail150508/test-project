<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Seo;
use App\Models\User;
use App\Models\Workshop;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\UserApplication;
use App\Models\WorkshopApplication;
use App\Http\Controllers\Controller;
use App\Interfaces\WorkshopInterface;

use App\Http\Resources\WorkshopResource;
use App\Http\Resources\WorkshopCollection;
use App\Http\Requests\Admin\WorkshopRequest;
use App\Http\Resources\WorkshopApplicationCollection;

class WorkshopController extends Controller
{
    protected $workshop;

    public function __construct(WorkshopInterface $workshop)
    {
        $this->workshop = $workshop;
    }

    public function index()
    {
        $current_date = Carbon::now()->format('Y-m-d');
        if (request()->per_page){
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;
            $query =  $this->workshop->query()
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orderBy('id', 'asc')
                ->paginate($perPage);
            return new WorkshopCollection($query);
        } else{
            $workshop = Workshop::query()->where('status','Active')->where('end_date', ">=", $current_date)->with('workshop_applications')->paginate(4);
            return new WorkshopCollection($workshop);
        }
    }

    public function userworkshopApplication($user_id) {


        if (request()->per_page) {
            $perPage = request()->per_page;
            $from_date = request()->selectedDate['from_date'];
            $to_date = request()->selectedDate['to_date'];
            $keyword = request()->keyword;

            $query = UserApplication::query()
            ->where('user_id',$user_id)
            ->where('application_type',"Workshop")
            ->with('user')
            ->with('workshop')

            ->when(request()->selectedDate['from_date'] != null && request()->selectedDate['to_date'] != null, function($query) use($from_date,$to_date) {
                $query->whereBetween('applyed_date', [$from_date, $to_date]);
            })
            ->whereHas('workshop', function($query) use($keyword)
            {
                $query->where('title', 'LIKE', "%$keyword%");
                // $query->orWhere('company_address', "LIKE", "%$keyword%");
                // $query->orWhere('job_title', "LIKE", "%$keyword%");
            })
            // ->where('withdraw_status',false)
            ->paginate($perPage);
            return new WorkshopApplicationCollection($query);
        }
    }

    public function workshopApplicationList($workshopId) {
        // $perPage = request()->per_page;
        // $query = WorkshopApplication::query()->with(['user','workshop'])->where('workshop_id',$workshopId)
        // ->orderBy('id', 'desc')
        // ->paginate($perPage);
        // return new WorkshopApplicationCollection($query);


        $perPage = request()->per_page;
        $query = UserApplication::query()->with(['user','workshop'])->where('workshop_id',$workshopId)
        ->orderBy('id', 'desc')
        ->paginate($perPage);
        return new WorkshopApplicationCollection($query);
    }

    public function deletedListIndex()
    {
        $workshop = $this->workshop->onlyTrashed();
        return response()->json($workshop);
    }

    public function store(WorkshopRequest $request)
    {
        $data = $request;

        // Generate the slug from the news title and Set the slug in the data array
        $slug = Str::slug($data['title']);
        $data['slug'] = $slug;

        $workshop = $this->workshop->create($data);

        // Data insert in seo table
        $seo = new Seo();
        $seo->model_name = 'App\Models\Workshop';
        $seo->model_id = $workshop->id;
        $seo->site = 'ccc';
        $seo->page_url = '/socio-psyche-counseling/' . $workshop->slug;
        $seo->title = $workshop->title;
        $seo->keywords = 'Socio Psyche Counseling';
        $seo->description = Str::limit(strip_tags($workshop->description), 100);
        $seo->save();

        return new WorkshopResource($workshop);
    }

    public function workshopApplicationStore(Request $request) {

        $WorkshopApplication = UserApplication::where('workshop_id', $request->workshop_id)
        ->where('user_id', $request->user_id)->where('application_type','Workshop')->exists();
        $authUser = User::where('id', $request->user_id)->exists();
        if(!$authUser) {
            $response = ['status' => 'error', 'message' => 'You are not logged in'];
        }
        elseif($WorkshopApplication) {
            $response = ['status' => 'error', 'message' => 'You Already Applyed for this Workshop'];
        }else {
            $WorkshopApplication = UserApplication::create($request->all());
            $response = ['status' => 'success', 'message' => 'You Applyed for this job successfully',200];
        }
        return response()->json($response);
    }

    // public function show(Workshop $workshop)
    // {
    //     $workshop = $this->workshop->findOrFail($workshop->id);
    //     return response()->json($workshop);
    // }

    public function show($slug)
    {
        $workshop = $this->workshop->where('slug', $slug)->firstOrFail();
        return response()->json($workshop);
    }

    public function userworkshopApplicationShow($workshop_application_id)
    {
        $userWorkshopApplicationView = UserApplication::with(['user','workshop'])->findOrFail($workshop_application_id);
        return response()->json($userWorkshopApplicationView);
    }

    public function edit($id)
    {
        $workshop = $this->workshop->findOrFail($id);
        return response()->json($workshop);
    }

    public function update(WorkshopRequest $request, Workshop $workshop)
    {
        $data = $request;

        // Generate the slug from the news title and Set the slug in the data array
        $slug = Str::slug($data['title']);
        $data['slug'] = $slug;

        $workshop = $this->workshop->update($workshop->id, $data);
        $request['update'] = 'update';

        // Update or create the SEO entry
        Seo::updateOrCreate(
            ['model_name' => 'App\Models\Workshop', 'model_id' => $workshop->id],
            [
                'site' => 'ccc',
                'page_url' => '/socio-psyche-counseling/' . $workshop->slug,
                'title' => $workshop->title,
                'keywords' => 'Socio Psyche Counseling',
                'description' => Str::limit(strip_tags($workshop->description), 100),
            ]
        );

        return new WorkshopResource($workshop);
    }

    public function destroy(Workshop $workshop)
    {
        $this->workshop->delete($workshop->id);
        return response()->json([
            'message' => trans('workshop.deleted'),
        ], 200);
    }

    public function restore($id)
    {
        $this->workshop->restore($id);
        return response()->json([
            'message' => trans('workshop.restored'),
        ], 200);
    }

    public function forceDelete($id)
    {
        $this->workshop->forceDelete($id);
        return response()->json([
            'message' => trans('workshop.permanent_deleted'),
        ], 200);
    }

    public function status(Request $request)
    {
        $this->workshop->status($request->id);
        return response()->json([
            'message' => trans('workshop.status_updated'),
        ], 200);
    }
}
