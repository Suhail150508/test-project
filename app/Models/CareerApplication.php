<?php

namespace App\Models;
use App\Helpers\ActivityLogHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class CareerApplication extends Model
{
    use HasFactory, LogsActivity;

    protected $guarded = ['id'];
    protected static $logName = 'CareerApplication';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['*'];
    protected static $ignoreChangedAttributes = [];

    public function getActivitylogOptions(): LogOptions
    {
        $log_name = trans(self::$logName . '.CareerApplication');
        return LogOptions::defaults()->useLogName($log_name)
        ->setDescriptionForEvent(fn(string $eventName)=> $log_name . ' ' . ActivityLogHelper::eventName($eventName))->logOnly(['*'])->logOnlyDirty();
    }

    public function resume(){
        return $this->belongsTo(Resume::class,'resume_id');
    }

}
