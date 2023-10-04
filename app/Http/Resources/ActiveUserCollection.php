<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ActiveUserCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'bn_name' => $user->bn_name,
                    'mobile' => $user->mobile,
                    'email' => $user->email,
                    'active' => $user->active,
                    'status' => $user->status,
                ];
            }),
        ];
    }
}
