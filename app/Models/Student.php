<?php

namespace App\Models;

use App\Helpers\ActivityLogHelper;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    protected $guarded = ['id'];

    protected static $logName = 'student';

    public function getActivitylogOptions(): LogOptions
    {
        $log_name = trans(self::$logName . '.student');
        return LogOptions::defaults()
            ->useLogName($log_name)
            ->setDescriptionForEvent(fn (string $eventName) => $log_name . ' ' . ActivityLogHelper::eventName($eventName))
            ->logOnly(['*'])
            ->logOnlyDirty();
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
    public function department()
    {
        return $this->hasOne('App\Models\Department', 'student_id');
    }
    public function skills()
    {
        return $this->hasMany('App\Models\Skill', 'student_id')->orderBy('order_by','asc');
    }
    public function trainings()
    {
        return $this->hasMany('App\Models\Training', 'student_id')->orderBy('order_by','asc');
    }
    public function workshops()
    {
        return $this->hasOne('App\Models\Workshop', 'student_id')->orderBy('order_by','asc');
    }
    public function achievements()
    {
        return $this->hasOne('App\Models\Achievement', 'student_id')->orderBy('order_by','asc');
    }

}
