<?php

namespace App\Models;

use App\Helpers\ActivityLogHelper;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobCategory extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $guarded = ['id'];
    protected static $logName = 'job_category';

    public function getActivitylogOptions(): LogOptions
    {
        $log_name = trans(self::$logName . '.job_category');
        return LogOptions::defaults()
            ->useLogName($log_name)
            ->setDescriptionForEvent(fn (string $eventName) => $log_name . ' ' . ActivityLogHelper::eventName($eventName))
            ->logOnly(['*'])
            ->logOnlyDirty();
    }
    public function jobsubcategories(){
        return $this->hasMany(JobSubCategory::class);
    }

    public function jobposts() {
        return $this->hasMany(JobPost::class ,'job_category_id');
    }
   
}
