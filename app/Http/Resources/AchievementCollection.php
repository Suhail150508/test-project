<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AchievementCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($achievement) {
                return [
                    'id' => $achievement->id,
                    'title' => $achievement->title,
                    'field' => $achievement->field,
                    'description' => $achievement->description,
                    'achievement_date' => $achievement->achievement_date,
                    'status' => $achievement->status,
                ];
            })
        ];
    }
}
