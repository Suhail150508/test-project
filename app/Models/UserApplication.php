<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserApplication extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function job_post()
    {
        return $this->belongsTo(JobPost::class,'job_post_id');
    }

    public function resume()
    {
        return $this->belongsTo(Resume::class,'resume_id');
    }

    public function workshop()
    {
        return $this->belongsTo(Workshop::class,'workshop_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function internship()
    {
        return $this->belongsTo(Internship::class,'internship_id');
    }
    public function training()
    {
        return $this->belongsTo(Training::class,'training_id');
    }
}
