<?php

namespace App\Http\Resources;

use Illuminate\Support\Arr;
use Illuminate\Http\Resources\Json\JsonResource;

class UserMenuActionResource extends JsonResource
{
    public function toArray($request)
    {
        $update = $this->update;
        $filterData = Arr::except($this, ['update']);
        return [
            "userMenuAction" => parent::toArray($filterData),
            "message" => trans($update ? 'user_menu_action/attribute.user_menu_updated_successfully' : 'user_menu_action/attribute.user_menu_created_successfully')
        ];
    }
}
