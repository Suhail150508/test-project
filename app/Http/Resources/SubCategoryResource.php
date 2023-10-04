<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubCategoryResource extends JsonResource
{
    public function toArray($request)
    {
          return [
              "subCategory"=>parent::toArray($request),
              "message"=>trans($request->update ? 'subCategory.updated': 'subCategory.created'),
          ];
    }
}
