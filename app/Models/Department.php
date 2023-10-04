<?php

namespace App\Models;

use App\Helpers\ActivityLogHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Department extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $guarded = ['id'];
    protected static $logName = 'department';

    public function getActivitylogOptions(): LogOptions
    {
        $log_name = trans(self::$logName . '.department');
        return LogOptions::defaults()->useLogName($log_name)
            ->setDescriptionForEvent(fn(string $eventName)=> $log_name . ' ' . ActivityLogHelper::eventName($eventName))->logOnly(['*'])->logOnlyDirty();
    }

    public function clubModerators()
    {
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
