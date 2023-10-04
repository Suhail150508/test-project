<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkshopApplication extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function workshop()
    {
        return $this->belongsTo(Workshop::class,'workshop_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
