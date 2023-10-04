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

class Category extends Model
{
    use HasFactory, SoftDeletes, 
    // HasSlug,
     LogsActivity;

    protected $guarded = ['id'];
    protected static $logName = 'category';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['*'];
    protected static $ignoreChangedAttributes = [];

    public function getActivitylogOptions(): LogOptions
    {
        $log_name = trans(self::$logName . '.category');
        return LogOptions::defaults()->useLogName($log_name)
            ->setDescriptionForEvent(fn(string $eventName)=> $log_name . ' ' . ActivityLogHelper::eventName($eventName))->logOnly(['*'])->logOnlyDirty();
    }
    
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }


    public function skills()
    {
        return $this->morphedByMany(Skill::class, 'categoryable');
    }

    public function news()
    {
        return $this->morphedByMany(News::class, 'categoryable');
    }

    public function subcategories()
    {
        return $this->hasMany(SubCategory::class);

    }
}
