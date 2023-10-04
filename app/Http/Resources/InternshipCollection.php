<?php

namespace App\Http\Resources;
use Carbon\Carbon;

use Illuminate\Http\Resources\Json\ResourceCollection;

class InternshipCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($internship) {
                return [
                    'id' => $internship->id,
                    'title' => $internship->title,
                    'slug' => $internship->slug,
                    'description' => $internship->description,
                    'start_date' => $internship->start_date,
                    'end_date' => $internship->end_date,
                    'current_date' => Carbon::now()->format('Y-m-d'),
                    'applyed_date' => $internship->applyed_date,
                    'status' => $internship->status,
                    'internship_applications' => $internship->internship_applications?$internship->internship_applications->count():"",
                    'user' => $internship->user,
                    'internship' => $internship->internship,
                ];
            })
        ];
    }
}
