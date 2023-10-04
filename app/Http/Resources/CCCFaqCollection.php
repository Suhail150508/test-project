<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CCCFaqCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($cccfaq) {
                return [
                    'id' => $cccfaq->id,
                    'question' => $cccfaq->question,
                    'answer' => $cccfaq->answer,
                    'order' => $cccfaq->order,
                    'status' => $cccfaq->status,
                    'faq_category' => $cccfaq->faq_category,
                ];
            })
        ];
    }
}
