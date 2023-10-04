<?php

namespace App\Models;

use App\Helpers\ActivityLogHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Skill extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $guarded = ['id'];
    protected static $logName = 'skill';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['*'];
    protected static $ignoreChangedAttributes = [];

    public function getActivitylogOptions(): LogOptions
    {
        $log_name = trans(self::$logName . '.skill');
        return LogOptions::defaults()->useLogName($log_name)
            ->setDescriptionForEvent(fn(string $eventName)=> $log_name . ' ' . ActivityLogHelper::eventName($eventName))->logOnly(['*'])->logOnlyDirty();
    }

    public function alumnis()
    {
        return $this->morphedByMany(Alumni::class, 'skillable');
    }

    public function categories()
    {
        return $this->morphToMany(Category::class, 'categoryable');
    }

    public function subCategories()
    {
        return $this->morphToMany(SubCategory::class, 'subcategoryable');
    }
}
