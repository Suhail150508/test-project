<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChapterMember extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    public function alumni()
    {
        return $this->belongsTo(Alumni::class);
    }
}
