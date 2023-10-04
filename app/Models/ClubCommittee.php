<?php

namespace App\Models;

use App\Helpers\ActivityLogHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ClubCommittee extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $guarded = ['id'];
    protected static $logName = 'club_committee';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['*'];
    protected static $ignoreChangedAttributes = [];

    public function getActivitylogOptions(): LogOptions
    {
        $log_name = trans(self::$logName . '.club_committee');
        return LogOptions::defaults()->useLogName($log_name)
            ->setDescriptionForEvent(fn(string $eventName)=> $log_name . ' ' . ActivityLogHelper::eventName($eventName))->logOnly(['*'])->logOnlyDirty();
    }

    /*    protected $casts = [
            'designation_ids' => 'array',
        ];*/

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function clubCommitteePhoto()
    {
        return $this->morphOne(File::class, 'fileable')->latest()->where('type', 'committee_image');
    }

    public function club(){
        return $this->belongsTo(Club::class);
    }

    public function designation(){
        return $this->belongsTo(Designation::class);
    }

    public function department(){
        return $this->belongsTo(Department::class);
    }

}
