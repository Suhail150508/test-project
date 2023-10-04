<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DesignationCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($designation) {
                return [
                    
                    'id' => $designation->id,
                    'name' => $designation->name,
                    'bn_name' => $designation->bn_name,
                    'short_name' => $designation->short_name,
                    'pay_scale' => $designation->pay_scale,
                    'status' => $designation->status,
                ];
            })
        ];
    }
}
