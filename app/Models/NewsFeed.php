<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NewsFeed extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function newsFeedFiles()
    {
        return $this->morphMany(NewsFeedFile::class, 'news_feed_fileable');
    }

    public function newsFeedImage()
    {
        return $this->morphMany(NewsFeedFile::class, 'news_feed_fileable')->latest()->where('type', 'image');
    }

    public function newsFeedVideo()
    {
        return $this->morphOne(NewsFeedFile::class, 'news_feed_fileable')->latest()->where('type', 'video');
    }

    public function newsFeedDocument()
    {
        return $this->morphOne(NewsFeedFile::class, 'news_feed_fileable')->latest()->where('type', 'document');
    }

    public function alumni()
    {
        return $this->belongsTo(Alumni::class);
    }
}
