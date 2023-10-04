<?php

namespace App\Models;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CccNews extends Model
{
    use HasFactory;
    
    use SoftDeletes;

    protected $guarded = ['id'];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function ccc_news()
    {
        return $this->morphOne(File::class, 'fileable')->latest()->where('type', 'ccc_news');
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function categories()
    {
        return $this->morphToMany(Category::class, 'categoryable');
    }

    public function subCategories()
    {
        return $this->morphToMany(SubCategory::class, 'subcategoryable');
    }
}
