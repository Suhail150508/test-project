<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GroupMember extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function alumni()
    {
        return $this->belongsTo(Alumni::class);
    }
}
