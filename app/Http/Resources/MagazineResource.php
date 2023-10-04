<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MagazineResource extends JsonResource
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
            "magazine"=>parent::toArray($request),
            "message"=>trans($request->update ? 'magazine.updated': 'magazine.created')
        ];
    }
}
