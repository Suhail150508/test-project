<?php

namespace App\Models;

use App\Helpers\ActivityLogHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class District extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $guarded = ['id'];
    protected static $logName = 'district';

    public function getActivitylogOptions(): LogOptions
    {
        $log_name = trans(self::$logName . '.district');
        return LogOptions::defaults()
            ->useLogName($log_name)
            ->setDescriptionForEvent(fn (string $eventName) => $log_name . ' ' . ActivityLogHelper::eventName($eventName))
            ->logOnly(['*'])
            ->logOnlyDirty();
    }

    public function designation(){
        return $this->belongsTo(Designation::class);
    }

    public function division(){
        return $this->belongsTo(Division::class);
    }

    public function greater_district(){
        return $this->belongsTo(GreaterDistrict::class);
    }

}
