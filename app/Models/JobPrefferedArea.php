<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPrefferedArea extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];

    public function jobCategories()
    {
        return $this->belongsTo(JobCategory::class,'job_category_ids');
    }
}
