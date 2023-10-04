<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DivisionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "division"=>parent::toArray($request),
            "message"=>trans($request->update ? 'division.division_type_updated': 'division.division_type_created')
        ];
    }
}
