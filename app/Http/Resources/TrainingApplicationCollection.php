<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TrainingApplicationCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($trainingApplications) {
                return [
                    'id' => $trainingApplications->id,
                    'training' => $trainingApplications->training,
                    'user' => $trainingApplications->user,
                    'user_id' => $trainingApplications->user_id,
                    'status' => $trainingApplications->status,
                    'training_image' => $trainingApplications->training_image?$trainingApplications->training_image->source:"",
                    'applyed_date' => $trainingApplications->created_at->format('Y-m-d'),
                ];
            })
        ];
    }
}
