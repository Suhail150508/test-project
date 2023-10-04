<?php

namespace App\Http\Resources;

use App\Models\Setting;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SettingCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($setting) {
                return [
                    'id' => $setting->id,
                    'key' => $setting->key,
                    'section' => Setting::sections()[$setting->key],
                    'value' => $setting->value,
                ];
            }),
            'sectionNames' => Setting::sections(),
        ];
    }
}
