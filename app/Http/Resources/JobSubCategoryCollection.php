<?php

namespace App\Http\Resources;
use App\Models\JobCategory;

use Illuminate\Http\Resources\Json\ResourceCollection;

class JobSubCategoryCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($jobsubcategory) {
                return [
                    'id' => $jobsubcategory->id,
                    'title' => $jobsubcategory->title,
                    'job_category_id' => $jobsubcategory->job_category_id,
                    'jobcategory' => $jobsubcategory->jobcategory,
                    'status' => $jobsubcategory->status,
                ];
            }),
            'jobcategories' => JobCategory::query()->get(),
        ];
    }
}
