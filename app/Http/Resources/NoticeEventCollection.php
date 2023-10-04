<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class NoticeEventCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($notice_event) {
                return [
                    'id' => $notice_event->id,
                    'title' => $notice_event->title,
                    'slug' => $notice_event->slug,
                    'description' => $notice_event->description,
                    'time' => $notice_event->time,
                    'date' => $notice_event->date,
                    'status' => $notice_event->status,
                ];
            })
        ];
    }
}
