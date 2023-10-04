<?php

namespace App\Rules;

use App\Helpers\ENTOBN;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

class LocalizedNumber implements Rule
{
    protected $val;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $this->val = $value;
        return preg_match('/^[.0-9]*$/',ENTOBN::convert_to_english($value));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->val .' '.trans('validation.incorrect_number');
    }
}
