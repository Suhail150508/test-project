<?php

namespace App\Models;

use App\Helpers\ActivityLogHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Designation extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $guarded = ['id'];
    protected static $logName = 'designation';

    public function getActivitylogOptions(): LogOptions
    {
        $log_name = trans(self::$logName . '.designation');
        return LogOptions::defaults()
            ->useLogName($log_name)
            ->setDescriptionForEvent(fn(string $eventName)=> $log_name . ' ' . ActivityLogHelper::eventName($eventName))
            ->logOnly(['*'])
            ->logOnlyDirty();
    }

    // public function getDescriptionForEvent(string $eventName): string
    // {
    //     self::$logName = trans(self::$logName.'.designation');
    //     return self::$logName .' '.ActivityLogHelper::eventName($eventName);
    // }

    public function clubModerators() {
        return $this->hasMany(ClubModerator::class);
    }

    public function delete()
    {
        // Delete related books
        $this->clubModerators()->delete();

        // Soft delete the author
        parent::delete();
    }
}
