<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class FundEventCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($fund_event) {
                return [
                    'id' => $fund_event->id,
                    'title' => $fund_event->title,
                    'description' => $fund_event->description,
                    'time' => $fund_event->time,
                    'date' => $fund_event->date,
                    'amount' => $fund_event->amount,
                    'status' => $fund_event->status,
                    'created_by' => $fund_event->created_by,
                    'fundEventDetails' => $fund_event->fundEventDetails,
                ];
            })
        ];
    }
}
