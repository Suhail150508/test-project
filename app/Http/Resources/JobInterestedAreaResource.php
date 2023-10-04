<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JobInterestedAreaResource extends JsonResource
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
            "jobInterestedArea"=>parent::toArray($request),
            "success"=>trans($request->update ? 'jobInterestedArea.updated': 'jobInterestedArea.created')
        ];
    }
}
