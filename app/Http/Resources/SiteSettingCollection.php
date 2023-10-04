<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SiteSettingCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($sitesetting) {
                return [
                    'id' => $sitesetting->id,
                    'contact_number' => $sitesetting->contact_number,
                    'contact_email' => $sitesetting->contact_email,
                    'address' => $sitesetting->address,
                    'status' => $sitesetting->status,
                ];
            })
        ];
    }
}
