<?php

namespace App\Models;

use App\Helpers\ActivityLogHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Content extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $guarded = [''];
    protected static $logName = 'content';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['*'];
    protected static $ignoreChangedAttributes = [];

    public function getActivitylogOptions(): LogOptions
    {
        $log_name = trans(self::$logName . '.index_title');
        return LogOptions::defaults()->useLogName($log_name)
            ->setDescriptionForEvent(fn(string $eventName)=> $log_name . ' ' . ActivityLogHelper::eventName($eventName))->logOnly(['*'])->logOnlyDirty();
    }
/*
    public function getDescriptionForEvent(string $eventName): string
    {
        self::$logName = trans(self::$logName.'.index_title');
        return self::$logName .' '.ActivityLogHelper::eventName($eventName);
    }*/

    public static function contentTypes()
    {
        return [
            'inspection_order' => 'পরিদর্শন আদেশ(প্রস্তাবিত)',
            'inspection_order_existing' => 'পরিদর্শন আদেশ(বিদ্যমান)',
            'note_sheet' => 'নোট শিট',
            'inspection_notice' => 'পরিদর্শন নোটিশ',
            'inspection_report' => 'পরিদর্শন রিপোর্ট',
            'department_orders' => 'দপ্তর আদেশ',
            'engineer_send_request' => 'প্রকৌশলী আহবান',
            'certificate' => 'সার্টিফিকেট',
            'application_return' => 'দরখাস্ত ফেরত',
            'application_reject' => 'দরখাস্ত বাতিল',
            'applicants_copy' => 'গ্রাহক কপি',
            'header' => 'হেডার',
            'contact' => 'যোগাযোগ করুন',
        ];
    }

    public static function findcontentType($content_type)
    {
        $content_types = self::contentTypes();
        foreach ($content_types as $key=>$value){
            if($key == $content_type){
                return $value;
                exit();
            }
        }
    }

    public static function getContent($applicants_copy=null)
    {
        if($applicants_copy != null){
            $data = Content::where('name',$applicants_copy)->first();
        }else {
            $data = array(
                'header' => Content::where('name','header')->first(),
                'inspection_order' => Content::where('name','inspection_order')->first(),
                'inspection_order_existing' => Content::where('name','inspection_order_existing')->first(),
            );
        }
        return $data;
    }
}
