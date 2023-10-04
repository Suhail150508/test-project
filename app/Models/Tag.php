<?php

namespace App\Models;

use App\Helpers\ActivityLogHelper;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $guarded = ['id'];
    protected static $logName = 'tag';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['*'];
    protected static $ignoreChangedAttributes = [];

    public function getActivitylogOptions(): LogOptions
    {
        $log_name = trans(self::$logName . '.tag');
        return LogOptions::defaults()->useLogName($log_name)
            ->setDescriptionForEvent(fn (string $eventName) => $log_name . ' ' . ActivityLogHelper::eventName($eventName))->logOnly(['*'])->logOnlyDirty();
    }

    public function cccNews()
    {
        return $this->morphedByMany(CccNews::class, 'taggable');
    }
}
