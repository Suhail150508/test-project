<?php

namespace App\Models;

use App\Helpers\ActivityLogHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class UserMenuAction extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $guarded = ['id'];
    protected static $logName = 'user_menu_action';

    public function getActivitylogOptions(): LogOptions
    {
        $log_name = trans(self::$logName . '/attribute.user_menu_action');
        return LogOptions::defaults()->useLogName($log_name)
            ->setDescriptionForEvent(fn(string $eventName)=> $log_name . ' ' . ActivityLogHelper::eventName($eventName))->logOnly(['*'])->logOnlyDirty();
    }

/*    public function getDescriptionForEvent(string $eventName): string
    {
        self::$logName = trans(self::$logName.'/attribute.user_menu_action');
        return self::$logName .' '.ActivityLogHelper::eventName($eventName);
    }*/

    public function menu()
    {
        return $this->belongsTo('App\Models\Menu', 'menu_id');
    }

    public function menuAction()
    {
        return $this->belongsTo('App\Models\MenuAction', 'menu_action_id');
    }

    public static function type(){
        /*
        these key will store in database and will work for user permission. So don't change these element key, otherwise user permission will be not working for these element. if you want to add new custom element please follow the example format .
        for example:
        return[
            'key' => 'Text'
        ];

      *Here key will store in database

     */
    return [
            'action' => 'Action',
            'section' => 'Section',
            'tab' => 'Tab',
            'button' => 'Button',
        ];
    }

    public static function getType($type)
    {
        $types = self::type();
        foreach ($types as $key=>$value){
            if($key == $type){
                return $value;
                exit();
            }
        }
    }
}
