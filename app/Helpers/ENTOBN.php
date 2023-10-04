<?php

namespace App\Helpers;


class ENTOBN
{
    public static function convert_to_bangla($engString) {
        $engNumber = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9);
        $bangNumber = array('০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯');
        return str_replace($engNumber, $bangNumber, $engString);
    }

    public static function convert_to_english($banString) {
        $bangNumber = array('০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯');
        $engNumber = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9);
        return str_replace($bangNumber, $engNumber, $banString);
    }
}
