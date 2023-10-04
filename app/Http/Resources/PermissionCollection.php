<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PermissionCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($permissions) {
                return [
                    'id' => $permissions->id,
                    'name' => $permissions->name,
                    'parent' => $permissions->parent,
                    'guard_name' => $permissions->guard_name,
                ];
            })
        ];
    }
}
