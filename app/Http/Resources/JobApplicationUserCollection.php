<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class JobApplicationUserCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($jobApplicationUser) {
                return [
                    'id' => $jobApplicationUser->user->id,
                    'name' => $jobApplicationUser->user->name,
                    'phone' => $jobApplicationUser->user->phone,
                    'email' => $jobApplicationUser->user->email,
                ];
            })
        ];
    }
}
