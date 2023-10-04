<?php

namespace App\Models;

use App\Helpers\ActivityLogHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class StudentWelfare extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $guarded = ['id'];
    protected static $logName = 'student_welfare';

    public function getActivitylogOptions(): LogOptions
    {
        $log_name = trans(self::$logName . '.student_welfare');
        return LogOptions::defaults()
            ->useLogName($log_name)
            ->setDescriptionForEvent(fn(string $eventName)=> $log_name . ' ' . ActivityLogHelper::eventName($eventName))
            ->logOnly(['*'])
            ->logOnlyDirty();
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function student_welfare()
    {
        return $this->morphOne(File::class, 'fileable')->latest()->where('type', 'student_welfare');
    }

    public function designation(){
        return $this->belongsTo(Designation::class);
    }
}
