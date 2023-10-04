<?php

namespace App\Http\Resources;

use App\Models\Menu;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MenuCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($menus) {
                return [
                    'id' => $menus->id,
                    'name' => $menus->name,
                    'bn_name' => $menus->bn_name,
                    'parent' => $menus->parent,
                    'route_name' => $menus->route_name,
                    'icon' => $menus->icon,
                    'order_by' => $menus->order_by,
                    'status' => $menus->status,
                ];
            }),
        ];
    }
}
