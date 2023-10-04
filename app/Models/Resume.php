<?php

namespace App\Models;


use App\Helpers\ActivityLogHelper;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resume extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $guarded = ['id'];
    protected static $logName = 'resume';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['*'];
    protected static $ignoreChangedAttributes = [];

    public function getActivitylogOptions(): LogOptions
    {
        $log_name = trans(self::$logName . '.resume');
        return LogOptions::defaults()->useLogName($log_name)
            ->setDescriptionForEvent(fn (string $eventName) => $log_name . ' ' . ActivityLogHelper::eventName($eventName))->logOnly(['*'])->logOnlyDirty();
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function resumeImage()
    {
        return $this->morphOne(File::class, 'fileable')->latest()->where('type', 'resume_image');
    }

    public function resumeFile()
    {
        return $this->morphOne(File::class, 'fileable')->latest()->where('type', 'resumeFile');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function career_application()
    {
        return $this->hasOne(CareerApplication::class,'resume_id');
    }
    public function specialization()
    {
        return $this->hasOne(Specialization::class,'resume_id');
    }
    public function employmenthistory()
    {
        return $this->hasMany(EmploymentHistory::class,'resume_id');
    }
    public function trainingSummary()
    {
        return $this->hasMany(TrainingSummary::class,'resume_id');
    }
    public function professionalCertificaion()
    {
        return $this->hasMany(ProfessionalCertification::class,'resume_id');
    }
    public function addresses()
    {
        return $this->hasMany(Address::class,'resume_id');
    }
    public function jobPreferredArea()
    {
        return $this->hasOne(JobPrefferedArea::class,'resume_id');
    }
    public function languages()
    {
        return $this->hasMany(LanguageProficiency::class,'resume_id');
    }
    public function educations()
    {
        return $this->hasMany(Education::class,'resume_id');
    }

    public function userRating()
    {
        return $this->hasOne(UserRating::class,'resume_id');
    }

}

