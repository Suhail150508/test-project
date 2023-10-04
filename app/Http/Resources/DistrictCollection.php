<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\Division;

class DistrictCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($destrict) {
                return [
                    
                    'id' => $destrict->id,
                    'name' => $destrict->name,
                    'bn_name' => $destrict->bn_name,
                    'division_id' => $destrict->division_id,
                    'division' => $destrict->division,
                    'division_id' => $destrict->division_id,
                    'status' => $destrict->status,
                ];
            }),
            'divisions' => Division::query()->get(),
        ];
    }
}
