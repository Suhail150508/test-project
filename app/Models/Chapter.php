<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chapter extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function profileImage()
    {
        return $this->morphOne(File::class, 'fileable')->latest()->where('type', 'chapter-profile');
    }

    public function backgroundImage()
    {
        return $this->morphOne(File::class, 'fileable')->latest()->where('type', 'chapter-background');
    }

    public function chapterMembers()
    {
        return $this->hasMany(ChapterMember::class);
    }

    public function alumni()
    {
        return $this->belongsTo(Alumni::class, 'user_id', 'id');
    }
}
