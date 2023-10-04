<?php

namespace App\Models;

use App\Helpers\ActivityLogHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;

class JobSeeker extends Model
{
    protected $guarded = ['id'];
    protected static $logName = 'job_seeker';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['*'];
    protected static $ignoreChangedAttributes = [];

    protected $casts = [
        'job_interested_area_ids' => 'array',
        'skill_ids' => 'array',
        'co_curricular_activity_ids' => 'array',
        'training_ids' => 'array',
        'workshop_ids' => 'array',
        'achievement_ids' => 'array',
        'professional_interest_ids' => 'array',
        'personal_interest_ids' => 'array',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        $log_name = trans(self::$logName . '.job_seeker');
        return LogOptions::defaults()->useLogName($log_name)
            ->setDescriptionForEvent(fn(string $eventName)=> $log_name . ' ' . ActivityLogHelper::eventName($eventName))->logOnly(['*'])->logOnlyDirty();
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function addresses(){
        return $this->hasMany(Address::class);
    }

    public function academics(){
        return $this->hasMany(Academic::class);
    }

    public function familyInformations(){
        return $this->hasMany(FamilyInformation::class);
    }

    public function experiences(){
        return $this->hasMany(Experience::class);
    }
}
