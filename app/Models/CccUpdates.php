<?php

namespace App\Models;

use App\Helpers\ActivityLogHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class CccUpdates extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $guarded = ['id'];
    protected static $logName = 'ccc_updates';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['*'];
    protected static $ignoreChangedAttributes = [];

    public function getActivitylogOptions(): LogOptions
    {
        $log_name = trans(self::$logName . '.ccc_updates');
        return LogOptions::defaults()->useLogName($log_name)
            ->setDescriptionForEvent(fn(string $eventName)=> $log_name . ' ' . ActivityLogHelper::eventName($eventName))->logOnly(['*'])->logOnlyDirty();
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function ccc_updates()
    {
        return $this->morphOne(File::class, 'fileable')->latest()->where('type', 'ccc_updates');
    }

    public function categories()
    {
        return $this->morphToMany(Category::class, 'categoryable');
    }
}
