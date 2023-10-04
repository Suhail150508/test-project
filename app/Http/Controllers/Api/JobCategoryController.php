<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\JobCategoryRequest;
use App\Interfaces\JobCategoryInterface;
use App\Models\JobCategory;
use App\Models\JobPost;
use Illuminate\Http\Request;
use App\Http\Resources\JobCategoryCollection;

class JobCategoryController extends Controller
{
    protected $jobCategory;

    public function __construct(JobCategoryInterface $jobCategory)
    {
        $this->jobCategory = $jobCategory;
    }

    public function index()
    {
        if (!empty(request()->all())) {
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;

            $query = JobCategory::query()
                ->with(['jobsubcategories','jobposts'])
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orderBy('id', 'desc')
                ->paginate($perPage);
            return new JobCategoryCollection($query);
        } else {
            $query = $this->jobCategory->get();
            return new JobCategoryCollection($query);
        }
    }

    public function deletedListIndex()
    {
        $jobCategorys = $this->jobCategory->onlyTrashed();

        return response()->json([
            'data ' => $jobCategorys
        ], 200);
    }

    public function store(JobCategoryRequest $request)
    {
        $jobCategory = $this->jobCategory->create($request);

        return response()->json([
            'data' => $jobCategory,
            'message' => trans('jobCategory.job_category_created_successfully'),
        ], 200);
    }

    public function show(JobCategory $jobCategory)
    {
        $jobCategory = $this->jobCategory->findOrFail($jobCategory->id);

        return response()->json([
            'data' => $jobCategory
        ], 200);
    }

    public function edit($id)
    {
        $jobCategory = $this->jobCategory->findOrFail($id);
        return response()->json($jobCategory);
    }

    public function update(JobCategoryRequest $request, JobCategory $jobCategory)
    {
        $jobCategory = $this->jobCategory->update($jobCategory->id, $request);

        return response()->json([
            'data' => $jobCategory,
            'message' => trans('jobCategory.job_category_updated_successfully'),
        ], 200);
    }

    public function destroy(JobCategory $jobCategory)
    {
        $jobCategory = $this->jobCategory->delete($jobCategory->id);

        return response()->json([
            'message' => trans('jobCategory.job_category_deleted_successfully'),
        ], 200);
    }

    public function restore($id)
    {
        $jobCategory = $this->jobCategory->restore($id);

        return response()->json([
            'message' => trans('jobCategory.job_category_restored_successfully'),
        ], 200);
    }

    public function forceDelete($id)
    {
        $jobCategory = $this->jobCategory->forceDelete($id);

        return response()->json([
            'message' => trans('jobCategory.job_category_deleted_permanently'),
        ], 200);
    }

    public function status(Request $request)
    {
        $jobCategory = $this->jobCategory->status($request->id);

        return response()->json([
            'message' => trans('jobCategory.job_category_status_updated_successfully'),
        ], 200);
    }
 
}
