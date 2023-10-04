<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class RoleCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($roles) {
                return [
                    'id' => $roles->id,
                    'name' => $roles->name,
                    'bn_name' => $roles->bn_name,
                    'status' => $roles->status,
                ];
            })
        ];
    }
}
