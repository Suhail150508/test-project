<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CoCurricularActivityResource extends JsonResource
{
   
    public function toArray($request)
    {
        return [
            "cocurricularactivity"=>parent::toArray($request),
            "success"=>trans($request->update ? 'cocurricularactivity.updated': 'cocurricularactivity.created')
        ];
    }
}
