<?php

namespace App\Http\Controllers\Api;

use App\Models\Alumni;
use App\Models\Achievement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\AchievementInterface;
use App\Http\Resources\AchievementResource;
use App\Http\Resources\AchievementCollection;
use App\Http\Requests\Admin\AchievementRequest;

class AchievementController extends Controller
{
    protected $achievement;

    public function __construct(AchievementInterface $achievement){
        $this->achievement = $achievement;
    }
    public function index()
    {
        if (request()->per_page) {
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;

            $query = Achievement::query()
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orderBy('id', 'asc')
                ->paginate($perPage);

            return new AchievementCollection($query);
        } else {
            $alumni = Alumni::findOrFail(request()->auth_id);
            if (!$alumni->achievements->isEmpty()) {
                $achievementIds = [];
                foreach ($alumni->achievements as $key => $value) {
                    $achievementIds[] = $value->id;
                }
                $query = Achievement::whereNotIn('id', $achievementIds)->get();
            } else {
                $query = $this->achievement->get();
            }

            return new AchievementCollection($query);
        }

    }

    public function deletedListIndex()
    {
        $achievements = $this->achievement->onlyTrashed();

        return response()->json($achievements);
    }

    public function store(AchievementRequest $request)
    {
        $achievement = $this->achievement->create($request);

        return new AchievementResource($achievement);
    }

    public function show(Achievement $achievement)
    {
        $achievement = $this->achievement->findOrFail($achievement->id);

        return response()->json($achievement);
    }

    public function edit($id)
    {
        $achievement = $this->achievement->findOrFail($id);
        return response()->json($achievement);
    }

    public function update(AchievementRequest $request, Achievement $achievement)
    {
        $achievement = $this->achievement->update($achievement->id, $request);
        $request['update'] = "update";

        return new AchievementResource($achievement);
    }

    public function destroy(Achievement $achievement)
    {
        $this->achievement->delete($achievement->id);

        return response()->json([
            'message' => trans('achievement.deleted'),
        ], 200);
    }

    public function restore($id)
    {
        $this->achievement->restore($id);

        return response()->json([
            'message' => trans('achievement.restored'),
        ], 200);
    }

    public function forceDelete($id)
    {
        $this->achievement->forceDelete($id);

        return response()->json([
            'message' => trans('achievement.permanent_deleted'),
        ], 200);
    }

    public function status(Request $request)
    {
        $this->achievement->status($request->id);

        return response()->json([
            'message' => trans('achievement.status_updated'),
        ], 200);

    }
}
