<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AdminCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($admin) {
                return [
                    'id' => $admin->id,
                    'name' => $admin->name,
                    'email' => $admin->email,
                    'username' => $admin->username,
                    'status' => $admin->status,
                ];
            })
        ];
    }
}
