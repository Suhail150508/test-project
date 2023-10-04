<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyDetailResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            "companyDetail"=>parent::toArray($request),
            "success"=>trans($request->update ? 'companyDetail.updated': 'companyDetail.created')
        ];
    }
}
