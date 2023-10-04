<?php


namespace App\Helpers;

class ActivityLogHelper
{
    public static function eventName($event_name)
    {
        return trans('activity_log.'.$event_name);
    }
}
