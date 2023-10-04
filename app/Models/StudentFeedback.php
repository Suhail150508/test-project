<?php

namespace App\Models;

use App\Helpers\ActivityLogHelper;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentFeedback extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $guarded = ['id'];

    protected static $logName = 'student_feedback';

    public function getActivitylogOptions(): LogOptions
    {
        $log_name = trans(self::$logName . '.student_feedback');
        return LogOptions::defaults()
            ->useLogName($log_name)
            ->setDescriptionForEvent(fn (string $eventName) => $log_name . ' ' . ActivityLogHelper::eventName($eventName))
            ->logOnly(['*'])
            ->logOnlyDirty();
    }
}
