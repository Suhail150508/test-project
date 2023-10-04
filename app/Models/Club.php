<?php

namespace App\Models;

use App\Helpers\ActivityLogHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Club extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $guarded = ['id'];
    protected static $logName = 'club';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['*'];
    protected static $ignoreChangedAttributes = [];

    public function getActivitylogOptions(): LogOptions
    {
        $log_name = trans(self::$logName . '.club');
        return LogOptions::defaults()->useLogName($log_name)
            ->setDescriptionForEvent(fn(string $eventName)=> $log_name . ' ' . ActivityLogHelper::eventName($eventName))->logOnly(['*'])->logOnlyDirty();
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function linkDetails()
    {
        return $this->morphMany(Link::class, 'linkable');
    }

    public function clubMainLogo()
    {
        return $this->morphOne(File::class, 'fileable')->latest()->where('type', 'club_main_logo');
    }

    public function clubHeaderLogo()
    {
        return $this->morphOne(File::class, 'fileable')->latest()->where('type', 'club_header_logo');
    }

    public function clubMedias(){
        return $this->hasMany(ClubMedia::class);
    }

    public function clubModerators(){
        return $this->hasMany(ClubModerator::class);
    }

    public function clubCommittees(){
        return $this->hasMany(ClubCommittee::class);
    }
}
