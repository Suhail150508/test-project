<?php

namespace App\Validators;

use App\Models\OffensiveWord;
use Illuminate\Support\Facades\Validator;

function getOffensiveWords($value)
{
    $offensiveWordsArray = OffensiveWord::where('status', 'Active')->pluck('keyword')->toArray();
    $matchingOffensiveWordsArray = [];
    foreach ($offensiveWordsArray as $word) {
        if (stripos($value, $word) !== false) {
            $matchingOffensiveWordsArray[] = $word;
        }
    }

    return $matchingOffensiveWordsArray;
}

class CustomValidator
{
    public static function offensiveWords($attribute, $value, $parameters, $validator)
    {
        $matchingOffensiveWordsArray = getOffensiveWords($value);

        if (!empty($matchingOffensiveWordsArray)) {
            $matchingOffensiveWordsString = implode(', ', $matchingOffensiveWordsArray);
            $validator->errors()->add($attribute, CustomValidator::offensiveWordsMessage($attribute, $matchingOffensiveWordsString));

            return false;
        }

        return true;
    }


    public static function offensiveWordsMessage($attribute, $matchingOffensiveWordsString)
    {
        return 'The '.$attribute.' field contains the offensive word: '.$matchingOffensiveWordsString;
    }
}
