<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SliderCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($slider) {
                return [
                    'id' => $slider->id,
                    'place' => $slider->place,
                    'title' => $slider->title,
                    'url' => $slider->url,
                    'short_description' => $slider->short_description,
                    'image' => $slider->sliderImage ? $slider->sliderImage->source : "",
                    'slider_status' => $slider->slider_status,
                ];
            })
        ];
    }
}
