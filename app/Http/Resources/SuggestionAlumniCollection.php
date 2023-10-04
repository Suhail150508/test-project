<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SuggestionAlumniCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($alumni) {
                return [
                    'id' => $alumni->id,
                    'ewu_id_no' => $alumni->ewu_id_no,
                    'first_name' => $alumni->first_name,
                    'middle_name' => $alumni->middle_name,
                    'last_name' => $alumni->last_name,
                    'blood_group' => $alumni->blood_group,
                    'organization' => $alumni->organization,
                    'designation_department' => $alumni->designation_department,
                    'occupation' => $alumni->occupation,
                    'doj' => $alumni->doj,
                    'profile_image' => $alumni->alumni ? $alumni->alumni->source : null,
                    'background_image' => $alumni->backgroundImage ? $alumni->backgroundImage->source : null,

                    'name' => $alumni->user ? $alumni->user->name : null,
                    'username' => $alumni->user ? $alumni->user->username : null,
                    'auth_email' =>$alumni->user ? $alumni->user->email : null,
                ];
            })
        ];
    }
}
