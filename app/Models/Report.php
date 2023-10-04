<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Report extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];

    public function reportType()
    {
        return $this->belongsTo(ReportType::class);
    }
}
