<?php

namespace App\Helpers;

class PivotHelper
{
    public static function pivotSyncArrayWithPivotFields($data,$pivot_info,$create_or_update) {
        $sync_array = [];
        if(is_array($data[$pivot_info['relation_key']])){
            for ($i=0; $i<count($data[$pivot_info['relation_key']]); $i++){
                if (count($pivot_info['pivot_fields']) == 1){
                    $sync_array[$data[$pivot_info['relation_key']][$i]] = [
                        $pivot_info['pivot_fields'][0] => $data[$pivot_info['pivot_fields'][0]][$i],
                        $create_or_update => \Auth::id()
                    ];
                } else if (count($pivot_info['pivot_fields']) == 2){
                    $sync_array[$data[$pivot_info['relation_key']][$i]] = [
                        $pivot_info['pivot_fields'][0] => $data[$pivot_info['pivot_fields'][0]][$i],
                        $pivot_info['pivot_fields'][1] => $data[$pivot_info['pivot_fields'][1]][$i],
                        $create_or_update => \Auth::id()
                    ];
                } else if (count($pivot_info['pivot_fields']) == 3){
                    $sync_array[$data[$pivot_info['relation_key']][$i]] = [
                        $pivot_info['pivot_fields'][0] => $data[$pivot_info['pivot_fields'][0]][$i],
                        $pivot_info['pivot_fields'][1] => $data[$pivot_info['pivot_fields'][1]][$i],
                        $pivot_info['pivot_fields'][2] => $data[$pivot_info['pivot_fields'][2]][$i],
                        $create_or_update => \Auth::id()
                    ];
                } else if (count($pivot_info['pivot_fields']) == 4){
                    $sync_array[$data[$pivot_info['relation_key']][$i]] = [
                        $pivot_info['pivot_fields'][0] => $data[$pivot_info['pivot_fields'][0]][$i],
                        $pivot_info['pivot_fields'][1] => $data[$pivot_info['pivot_fields'][1]][$i],
                        $pivot_info['pivot_fields'][2] => $data[$pivot_info['pivot_fields'][2]][$i],
                        $pivot_info['pivot_fields'][3] => $data[$pivot_info['pivot_fields'][3]][$i],
                        $create_or_update => \Auth::id()
                    ];
                }
            }
        } else {
            if (count($pivot_info['pivot_fields']) == 1){
                $sync_array[$data[$pivot_info['relation_key']]] = [$pivot_info['pivot_fields'][0] => $data[$pivot_info['pivot_fields'][0]],$create_or_update => \Auth::id()];
            } elseif (count($pivot_info['pivot_fields']) == 2){
                $sync_array[$data[$pivot_info['relation_key']]] = [
                    $pivot_info['pivot_fields'][0] => $data[$pivot_info['pivot_fields'][0]],
                    $pivot_info['pivot_fields'][1] => $data[$pivot_info['pivot_fields'][1]],
                    $create_or_update => \Auth::id()
                ];
            } elseif (count($pivot_info['pivot_fields']) == 3){
                $sync_array[$data[$pivot_info['relation_key']]] = [
                    $pivot_info['pivot_fields'][0] => $data[$pivot_info['pivot_fields'][0]],
                    $pivot_info['pivot_fields'][1] => $data[$pivot_info['pivot_fields'][1]],
                    $pivot_info['pivot_fields'][2] => $data[$pivot_info['pivot_fields'][2]],
                    $create_or_update => \Auth::id()
                ];
            } elseif (count($pivot_info['pivot_fields']) == 4){
                $sync_array[$data[$pivot_info['relation_key']]] = [
                    $pivot_info['pivot_fields'][0] => $data[$pivot_info['pivot_fields'][0]],
                    $pivot_info['pivot_fields'][1] => $data[$pivot_info['pivot_fields'][1]],
                    $pivot_info['pivot_fields'][2] => $data[$pivot_info['pivot_fields'][2]],
                    $pivot_info['pivot_fields'][3] => $data[$pivot_info['pivot_fields'][3]],
                    $create_or_update => \Auth::id()
                ];
            }
        }
        return $sync_array;
    }

    public static function pivotSyncArray($data,$pivot_info,$create_or_update) {
        $sync_array = [];
        if(is_array($data[$pivot_info['relation_key']])){
            for ($i=0; $i<count($data[$pivot_info['relation_key']]); $i++){
                $sync_array[$data[$pivot_info['relation_key']][$i]] = [$create_or_update => \Auth::id()];
            }
        } else {
            $sync_array[$data[$pivot_info['relation_key']]] = [$create_or_update => \Auth::id()];
        }
        return $sync_array;
    }

}
