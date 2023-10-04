<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClassMemoriesMember extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];

    public function classMemories()
    {
        return $this->belongsTo(ClassMemories::class);
    }

    public function alumni()
    {
        return $this->belongsTo(Alumni::class);
    }
}
