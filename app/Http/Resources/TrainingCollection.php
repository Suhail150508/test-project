<?php

namespace App\Http\Resources;
use Carbon\Carbon;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TrainingCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($trainings) {
                return [
                    'id' => $trainings->id,
                    'job_category_id' => $trainings->job_category_id,
                    'title' => $trainings->title,
                    'slug' => $trainings->slug,
                    'description' => $trainings->description,
                    'start_date' => $trainings->start_date,
                    'current_date' => Carbon::now()->format('Y-m-d'),
                    'end_date' => $trainings->end_date,
                    'status' => $trainings->status,
                    'training_image' => $trainings->training_image?$trainings->training_image->source:"",
                    'training_applications' =>$trainings->training_applications->count(),
                ];
            })
        ];
    }
}
