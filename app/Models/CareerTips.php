<?php

namespace App\Models;

use App\Helpers\ActivityLogHelper;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CareerTips extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $guarded = ['id'];
    protected static $logName = 'ccc_faq';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['*'];
    protected static $ignoreChangedAttributes = [];

    public function getActivitylogOptions(): LogOptions
    {
        $log_name = trans(self::$logName . '.ccc_faq');
        return LogOptions::defaults()->useLogName($log_name)
            ->setDescriptionForEvent(fn (string $eventName) => $log_name . ' ' . ActivityLogHelper::eventName($eventName))->logOnly(['*'])->logOnlyDirty();
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function careerTips()
    {
        return $this->morphOne(File::class, 'fileable')->latest()->where('type', 'career_tips');
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
