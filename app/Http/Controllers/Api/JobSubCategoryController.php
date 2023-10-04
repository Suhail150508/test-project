<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobSubCategory;
use App\Interfaces\JobSubCategoryInterface;
use App\Http\Resources\JobSubCategoryCollection;

class JobSubCategoryController extends Controller
{
  
    protected $jobSubCategory;

    public function __construct(JobSubCategoryInterface $jobSubCategory)
    {
        $this->jobSubCategory = $jobSubCategory;
    }

    public function index()
    {
        if (!empty(request()->all())) {
            // If more than 0
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;

            $query = JobSubCategory::query()
                ->with('jobcategory')
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orderBy('id', 'desc')
                ->paginate($perPage);

            return new JobSubCategoryCollection($query);
        } else {
            // If 0
            $query = JobSubCategory::with(['jobcategory'])->get();
            return new JobSubCategoryCollection($query);
        }
    }


   
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        $jobSubCategory = $this->jobSubCategory->create($request);

        return response()->json([
            'data' => $jobSubCategory,
            'message' => trans('job SubCategory_created_successfully'),
        ], 200);
    }

 
    public function show($id)
    {
        //
    }

  
    public function edit($id)
    {
        $jobSubCategory = $this->jobSubCategory->findOrFail($id);
        return response()->json($jobSubCategory);
    }

   
    public function update(Request $request, JobSubCategory $jobsub_category)
    {
        $jobSubCategory = $this->jobSubCategory->update($jobsub_category->id, $request);

        return response()->json([
            'data' => $jobSubCategory,
            'message' => trans('jobSubCategory_updated_successfully'),
        ], 200);
    }

   
    public function destroy(JobSubCategory $jobsub_category)
    {
        $jobSubCategory = $this->jobSubCategory->delete($jobsub_category->id);

        return response()->json([
            'message' => trans('jobsub_category_deleted_successfully'),
        ], 200);
    }

    public function categorysubcategory(JobSubCategory $jobsub_category)
    {
        $jobSubCategory = $this->jobSubCategory->delete($jobsub_category->id);

        return response()->json([
            'message' => trans('jobsub_category_deleted_successfully'),
        ], 200);
    }

    public function categorysubcategories($id) {
       $categorysubcategories = JobSubCategory::where('job_category_id',$id)->get();
       return response()->json($categorysubcategories);
    }
}
