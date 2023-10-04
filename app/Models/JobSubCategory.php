<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobSubCategory extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function jobcategory(){
        return $this->belongsTo(JobCategory::class ,'job_category_id');
    }

    public function jobposts() {
        return $this->hasMany(JobPost::class ,'job_sub_category_id');
    }
}
