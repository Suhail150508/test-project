<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class JobBlogCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($job_blog) {
                return [
                    'id' => $job_blog->id,
                    'title' => $job_blog->title,
                    'description' => $job_blog->description,
                    'image' => "image",
                ];
            })
        ];
    }
}
