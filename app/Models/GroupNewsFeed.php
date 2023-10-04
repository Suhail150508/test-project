<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GroupNewsFeed extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function groupNewsFeedFiles()
    {
        return $this->morphMany(GroupNewsFeedFile::class, 'group_news_feed_fileable');
    }

    public function groupNewsFeedImage()
    {
        return $this->morphMany(GroupNewsFeedFile::class, 'group_news_feed_fileable')->latest()->where('type', 'image');
    }

    public function groupNewsFeedVideo()
    {
        return $this->morphOne(GroupNewsFeedFile::class, 'group_news_feed_fileable')->latest()->where('type', 'video');
    }

    public function groupNewsFeedDocument()
    {
        return $this->morphOne(GroupNewsFeedFile::class, 'group_news_feed_fileable')->latest()->where('type', 'document');
    }

    public function alumni()
    {
        return $this->belongsTo(Alumni::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
