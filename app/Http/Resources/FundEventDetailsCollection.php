<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class FundEventDetailsCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($fund_event_details) {
                return [
                    'id' => $fund_event_details->id,
                    'fund_event' => $fund_event_details->fundEvent,
                    'user' => $fund_event_details->user,
                    'paid_amount' => $fund_event_details->paid_amount,
                    'comments' => $fund_event_details->comments,
                    'created_at' => $fund_event_details->created_at,
                ];
            })
        ];
    }
}
