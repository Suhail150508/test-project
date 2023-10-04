<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ContactUsCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($contactUs) {
                return [
                    'id' => $contactUs->id,
                    'address' => $contactUs->address,
                    'phone' => $contactUs->phone,
                    'email' => $contactUs->email,
                    'room_no' => $contactUs->room_no,
                    'description' => $contactUs->description,
                    'status' => $contactUs->status,
                ];
            })
        ];
    }
}
