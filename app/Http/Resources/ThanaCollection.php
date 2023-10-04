<?php

namespace App\Http\Resources;

use App\Models\District;
use App\Models\Division;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ThanaCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($thanas) {
                return [
                    'id' => $thanas->id,
                    'name' => $thanas->name,
                    'bn_name' => $thanas->bn_name,
                    'division' => $thanas->division,
                    'district' => $thanas->district,
                    'division_id' => $thanas->division_id,
                    'district_id' => $thanas->district_id,
                    'status' => $thanas->status,
                ];
            }),
            'divisions' => Division::query()->get(),
            'districts' => District::query()->get(),
        ];
    }
}