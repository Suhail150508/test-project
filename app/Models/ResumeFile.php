<?php

namespace App\Models;



use App\Helpers\ActivityLogHelper;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ResumeFile extends Model
{
    use HasFactory, LogsActivity;

    protected $guarded = ['id'];
    protected static $logName = 'resume_file';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['*'];
    protected static $ignoreChangedAttributes = [];

    public function getActivitylogOptions(): LogOptions
    {
        $log_name = trans(self::$logName . '.resume_file');
        return LogOptions::defaults()->useLogName($log_name)
            ->setDescriptionForEvent(fn (string $eventName) => $log_name . ' ' . ActivityLogHelper::eventName($eventName))->logOnly(['*'])->logOnlyDirty();
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function resumeCv()
    {
        return $this->morphOne(File::class, 'fileable')->latest()->where('type', 'resume_cv');
    }
    public function resumeVideo()
    {
        return $this->morphOne(File::class, 'fileable')->latest()->where('type', 'resume_video');
    }

}

