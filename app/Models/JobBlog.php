<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobBlog extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function job_blog()
    {
        return $this->morphOne(File::class, 'fileable')->latest()->where('type', 'job_blog');
    }
}
