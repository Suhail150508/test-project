<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function coverImage()
    {
        return $this->morphOne(File::class, 'fileable')->latest()->where('type', 'event-cover-photo');
    }

    public function alumni()
    {
        return $this->belongsTo(Alumni::class, 'user_id', 'id');
    }

    public function eventMembers()
    {
        return $this->hasMany(EventMember::class);
    }
}
