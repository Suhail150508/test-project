<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use App\Helpers\ActivityLogHelper;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Multicaret\Acquaintances\Traits\CanFollow;
use Multicaret\Acquaintances\Traits\Friendable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Multicaret\Acquaintances\Traits\CanBeFollowed;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Alumni extends Authenticatable
{
    use HasFactory, SoftDeletes, LogsActivity, HasApiTokens, Friendable, CanFollow, CanBeFollowed, Notifiable;

    protected $guard = "alumni";

    protected $guarded = ['id'];

    protected static $logName = 'alumni';

    public function getActivitylogOptions(): LogOptions
    {
        $log_name = trans(self::$logName . '.alumni');
        return LogOptions::defaults()
            ->useLogName($log_name)
            ->setDescriptionForEvent(fn (string $eventName) => $log_name . ' ' . ActivityLogHelper::eventName($eventName))
            ->logOnly(['*'])
            ->logOnlyDirty();
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function alumni()
    {
        return $this->morphOne(File::class, 'fileable')->latest()->where('type', 'alumni');
    }

    public function backgroundImage()
    {
        return $this->morphOne(File::class, 'fileable')->latest()->where('type', 'alumni-backgroud');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function skills()
    {
        return $this->morphToMany(Skill::class, 'skillable');
    }

    public function achievements()
    {
        return $this->morphToMany(Achievement::class, 'achievementable');
    }

    public function experiences()
    {
        return $this->hasMany(Experience::class, 'user_id', 'id');
    }

    public function educations()
    {
        return $this->hasMany(Education::class, 'user_id', 'id');
    }

    public function newsFeeds()
    {
        return $this->hasMany(NewsFeed::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'user_id', 'id');
    }

    protected $casts = [
        'professional_interest_ids' => 'array',
        'achievement_ids' => 'array',
        'skill_ids' => 'array'
    ];

    /*protected function jobInterestedAreaIds(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => json_encode($value), // Mutator
            get: fn ($value) => json_decode($value), // Accessor
        );
    }

    protected function professionalInterestIds(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => json_encode($value), // Mutator
            get: fn ($value) => json_decode($value), // Accessor
        );
    }

    protected function personalInterestIds(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => json_encode($value), // Mutator
            get: fn ($value) => json_decode($value), // Accessor
        );
    }

    protected function achievementIds(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => json_encode($value), // Mutator
            get: fn ($value) => json_decode($value), // Accessor
        );
    }

    protected function skillIds(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => json_encode($value), // Mutator
            get: fn ($value) => json_decode($value), // Accessor
        );
    }

    protected function trainingIds(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => json_encode($value), // Mutator
            get: fn ($value) => json_decode($value), // Accessor
        );
    }

    protected function coCurricularActivityIds(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => json_encode($value), // Mutator
            get: fn ($value) => json_decode($value), // Accessor
        );
    }*/
}
