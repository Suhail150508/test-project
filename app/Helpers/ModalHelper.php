<?php

namespace App\Helpers;


class ModalHelper
{
    public static function content(array $content_array = []) {

        $data = [
            'title' => @$content_array['title'],
            'form_action' => @$content_array['form_action'],
            'method' => @$content_array['method'],
            'model' => @$content_array['model'],
            'body' => @$content_array['body'],
            'included_path' => @$content_array['included_path'],
            'data' => @$content_array,
        ];
        $content = (string)view('components.modal_content',$data);

        return $content;
    }

}
