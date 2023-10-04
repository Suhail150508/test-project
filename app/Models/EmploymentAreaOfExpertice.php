<?php

namespace App\Models;


use App\Helpers\ActivityLogHelper;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmploymentAreaOfExpertice extends Model
{
    use HasFactory, LogsActivity;

    protected $guarded = ['id'];
    protected static $logName = 'area_of_expertice';

    public function getActivitylogOptions(): LogOptions
    {
        $log_name = trans(self::$logName . '.area_of_expertice');
        return LogOptions::defaults()
            ->useLogName($log_name)
            ->setDescriptionForEvent(fn (string $eventName) => $log_name . ' ' . ActivityLogHelper::eventName($eventName))
            ->logOnly(['*'])
            ->logOnlyDirty();
    }
    public function area_of_expertices(){
        return $this->hasMany(EmploymentAreaOfExpertice::class);
    }

   
}
