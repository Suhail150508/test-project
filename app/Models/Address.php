<?php

namespace App\Models;

use App\Helpers\ActivityLogHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Address extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $guarded = ['id'];
    protected static $logName = 'achievement';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['*'];
    protected static $ignoreChangedAttributes = [];

    public function getActivitylogOptions(): LogOptions
    {
        $log_name = trans(self::$logName . '.achievement');
        return LogOptions::defaults()->useLogName($log_name)
            ->setDescriptionForEvent(fn(string $eventName)=> $log_name . ' ' . ActivityLogHelper::eventName($eventName))->logOnly(['*'])->logOnlyDirty();
    }

    public function jobSeeker(){
        return $this->belongsTo(JobSeeker::class);
    }
    public function job(){
        return $this->belongsTo(JobPost::class);
    }

    public function alumni()
    {
        return $this->belongsTo(Alumni::class);
    }

    public function companyDetail(){
        return $this->belongsTo(CompanyDetail::class);
    }

    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function division(){
        return $this->belongsTo(Division::class,'division_id');
    }

    public function district(){
        return $this->belongsTo(District::class);
    }


    public function thana(){
        return $this->belongsTo(Thana::class);
    }
}
