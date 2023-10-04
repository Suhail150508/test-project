<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClassMemoriesNewsFeed extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];

    public function classMemoriesNewsFeedFiles()
    {
        return $this->morphMany(ClassMemoriesNewsFeedFile::class, 'class_memories_news_feed_fileable');
    }

    public function classMemoriesNewsFeedImage()
    {
        return $this->morphMany(ClassMemoriesNewsFeedFile::class, 'class_memories_news_feed_fileable')->latest()->where('type', 'image');
    }

    public function alumni()
    {
        return $this->belongsTo(Alumni::class);
    }

    public function classMemories()
    {
        return $this->belongsTo(ClassMemories::class);
    }
}
