<?php

namespace App\Models;

use App\Helpers\ActivityLogHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Employee extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $guarded = ['id'];
    protected static $logName = 'employee';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['*'];
    protected static $ignoreChangedAttributes = [];

    public function getActivitylogOptions(): LogOptions
    {
        $log_name = trans(self::$logName . '.employee');
        return LogOptions::defaults()->useLogName($log_name)
            ->setDescriptionForEvent(fn(string $eventName)=> $log_name . ' ' . ActivityLogHelper::eventName($eventName))->logOnly(['*'])->logOnlyDirty();
    }

/*    public function getDescriptionForEvent(string $eventName): string
    {
        self::$logName = trans(self::$logName.'.employee');
        return self::$logName .' '.ActivityLogHelper::eventName($eventName);
    }*/

    public static function religions()
    {
        return [
            'Islam' => 'ইসলাম',
            'Hinduism' => 'হিন্দু',
            'Christianity' => 'খৃস্টান',
            'Buddhism' => 'বৌদ্ধ',
            'Other Religion' => 'অন্য ধর্ম',
        ];
    }

    public static function genders()
    {
        return [
            'Male' => 'পুরুষ',
            'Female' => 'মহিলা',
            'Other' => 'অন্যান্য',
        ];
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    public function workshop()
    {
        return $this->belongsTo(Workshop::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function profile_picture()
    {
        return $this->morphOne(File::class, 'fileable')->latest()->where('type','profile_picture');
    }

    public function signature()
    {
        return $this->morphOne(File::class, 'fileable')->latest()->where('type','signature');
    }

}
