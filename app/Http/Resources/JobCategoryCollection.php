<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class JobCategoryCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($jobcategory) {
                return [
                    'id' => $jobcategory->id,
                    'title' => $jobcategory->title,
                    'icon' => $jobcategory->icon,
                    'description' => $jobcategory->description,
                    'jobsubcategories' => $jobcategory->jobsubcategories,
                    'type' => $jobcategory->type,
                    'status' => $jobcategory->status,
                    'job_count'=>$jobcategory->jobposts?$jobcategory->jobposts->count():"0",
                ];
            })
        ];
    }
}
