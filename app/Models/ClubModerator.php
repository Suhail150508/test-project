<?php

namespace App\Models;

use App\Helpers\ActivityLogHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ClubModerator extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $guarded = ['id'];
    protected static $logName = 'club_moderator';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['*'];
    protected static $ignoreChangedAttributes = [];

    public function getActivitylogOptions(): LogOptions
    {
        $log_name = trans(self::$logName . '.club_moderator');
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

    public function clubModeratorPhoto()
    {
        return $this->morphOne(File::class, 'fileable')->latest()->where('type', 'moderator_image');
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
