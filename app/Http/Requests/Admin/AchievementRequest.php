<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AchievementRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "title" => "required|min:3|max:300",
            "description" => "required",
            "achievement_date" => "required",
        ];
    }
}
