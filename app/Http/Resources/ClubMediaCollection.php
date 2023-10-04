<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ClubMediaCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($clubMedias) {
                return [
                    'id' => $clubMedias->id,
                    'club' => $clubMedias->club,
                    'type' => $clubMedias->type,
                    'title' => $clubMedias->title,
                    'date_from' => $clubMedias->date_from,
                    'date_to' => $clubMedias->date_to,
                    'media_main_image' => $clubMedias->clubMediaPhoto ? $clubMedias->clubMediaPhoto->source : "",
                    'description' => $clubMedias->description,
                    'status' => $clubMedias->status,
                    'c_address' => $clubMedias->c_address,
                    'c_phone' => $clubMedias->c_phone,
                    'c_email' => $clubMedias->c_email,

                ];
            })
        ];
    }
}
