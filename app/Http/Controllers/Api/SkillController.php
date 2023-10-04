<?php

namespace App\Http\Controllers\Api;

use App\Models\Skill;
use App\Models\Alumni;
use Illuminate\Http\Request;
use App\Interfaces\SkillInterface;
use App\Http\Controllers\Controller;
use App\Http\Resources\SkillResource;
use App\Http\Resources\SkillCollection;
use App\Http\Requests\Admin\SkillRequest;

class SkillController extends Controller
{
    protected $skill;

    public function __construct(SkillInterface $skill)
    {
        $this->skill=$skill;
    }

    public function index()
    {
        // dd('hi');
        if (request()->per_page) {
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;

            $query = Skill::query()
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orderBy('id', 'asc')
                ->paginate($perPage);

            return new SkillCollection($query);

        }elseif(request()->job_resume_skill) 
        {
            $query = $this->skill->get();
            return new SkillCollection($query);
        } else {
                $alumni = Alumni::findOrFail(request()->auth_id);
                if ($alumni->skills) {
                    $skillIds = [];
                    foreach ($alumni->skills as $key => $value) {
                        $skillIds[] = $value->id;
                    }
                    $query = Skill::whereNotIn('id', $skillIds)->get();
                } else{
                    $query = $this->skill->get();
                }
            return new SkillCollection($query);
        }
    }

    public function deletedListIndex()
    {
        $skill = $this->skill->onlyTrashed();
        return response()->json($skill);
    }

    public function store(SkillRequest $request)
    {
        $skill = $this->skill->create($request);
        $categories = $skill->categories()->attach($request->categories);
        $subCategories = $skill->subCategories()->attach($request->subCategories);

        return new SkillResource($skill, $categories, $subCategories);
    }

    public function show(Skill $skill)
    {
        $skill = $this->skill->findOrFail($skill->id);
        return response()->json($skill);
    }

    public function edit(Skill $skill)
    {
        $skill = $this->skill->findOrFail($skill->id);
        return response()->json($skill);
    }

    public function update(SkillRequest $request, Skill $skill)
    {
        $skill = $this->skill->update($skill->id,$request);
        $request['update'] = 'update';
        return new SkillResource($skill);
    }

    public function destroy(Skill $skill)
    {
        $this->skill->delete($skill->id);
        return response()->json([
            'message' => trans('skill.deleted'),
        ], 200);
    }

    public function restore($id)
    {
        $this->skill->restore($id);
        return response()->json([
            'message' => trans('skill.restored'),
        ], 200);
    }

    public function forceDelete($id)
    {
        $this->skill->forceDelete($id);
        return response()->json([
            'message' => trans('skill.permanent_deleted'),
        ], 200);
    }

    public function status(Request $request)
    {
        $this->skill->status($request->id);
        return response()->json([
            'message' => trans('skill.status_updated'),
        ], 200);
    }

}
