<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MarqueeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "marquee"=>parent::toArray($request),
            "message"=>trans($request->update ? 'marquee text.updated': 'marquee text.created'),
        ];
    }
}
