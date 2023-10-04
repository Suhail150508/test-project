<?php

namespace App\Helpers;

class HtmlHelper
{
    public static function dropdownOptions($collections) {

        $options = '<option value="">'.trans("common.select_one").'</option>';
        if(@$collections != ''){
            foreach ($collections as $key => $value){
                $options .= '<option value="'.$key.'">'.$value.'</option>';
            }
        }

        $data = [
            'options' => $options
        ];
        return $data;

    }

}
