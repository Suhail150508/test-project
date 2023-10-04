<?php

namespace App\Models;

// use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use App\Helpers\ActivityLogHelper;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubCategory extends Model
{
    use HasFactory, SoftDeletes,
    // HasSlug,
     LogsActivity;

    protected $guarded = ['id'];
    protected static $logName = 'sub_category';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['*'];
    protected static $ignoreChangedAttributes = [];

    public function getActivitylogOptions(): LogOptions
    {
        $log_name = trans(self::$logName . '.sub_category');
        return LogOptions::defaults()->useLogName($log_name)
            ->setDescriptionForEvent(fn(string $eventName)=> $log_name . ' ' . ActivityLogHelper::eventName($eventName))->logOnly(['*'])->logOnlyDirty();
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function cccNews()
    {
        return $this->morphedByMany(CccNews::class, 'subcategoryable');
    }

    public function cccUpdates()
    {
        return $this->morphedByMany(CccUpdates::class, 'subcategoryable');
    }

    public function news()
    {
        return $this->morphedByMany(News::class, 'subcategoryable');
    }

    public function skills()
    {
        return $this->morphedByMany(Skill::class, 'subcategoryable');
    }
}
