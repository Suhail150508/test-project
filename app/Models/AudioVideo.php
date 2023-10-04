<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AudioVideo extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function ccc_audiovideo()
    {
        return $this->morphOne(File::class, 'fileable')->latest()->where('type', 'ccc_audiovideo');
    }
}
