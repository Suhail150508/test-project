<?php


namespace App\Helpers;


use Illuminate\Support\Str;
use Spatie\Activitylog\Models\Activity;

class CommonHelper
{
    public static function trackingNumberDaily(string $model,array $parameters = null){
        $count = $model::query()
            ->whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('m'))
            ->whereDay('created_at', date('d'))
            ->count();

        return $parameters['prefix'].'-'.date('Y').date('m').date('d').str_pad($count, 2, '0', STR_PAD_LEFT);
    }

    public static function trackingNumberMonthly(string $model,array $parameters = null){
        $count = $model::query()
            ->whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('m'))
            ->count();

        return $parameters['prefix'].'-'.date('Y').date('m').date('d').str_pad($count, 2, '0', STR_PAD_LEFT);
    }

    public static function trackingNumberYearly(string $model,array $parameters = null){
        $count = $model::query()
            ->whereYear('created_at', date('Y'))
            ->count();

        return $parameters['prefix'].'-'.date('Y').date('m').date('d').str_pad($count, 2, '0', STR_PAD_LEFT);
    }

    public static function findType($types,$type){
        foreach ($types as $key=>$value){
            if($key == $type){
                return $value;
                exit();
            }elseif(str_contains($value,$type)){
                return $key;
                exit();
            }
        }
    }

    public static function find_relation($model, string $relation){
        return @$model->{$relation}->name;
    }

}
