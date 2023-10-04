<?php

namespace App\Models;

use App\Helpers\ActivityLogHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class JobPost extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $guarded = ['id'];
    protected static $logName = 'jobPost';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['*'];
    protected static $ignoreChangedAttributes = [];

    protected $casts = [
        'department_ids' => 'array',
        'skill_ids' => 'array',
        'training_ids' => 'array',
        'job_area_districts' => 'array',
        'professional_certification_ids' => 'array'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        $log_name = trans(self::$logName . '.jobPost');
        return LogOptions::defaults()->useLogName($log_name)
            ->setDescriptionForEvent(fn(string $eventName)=> $log_name . ' ' . ActivityLogHelper::eventName($eventName))->logOnly(['*'])->logOnlyDirty();
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function websiteLogo()
    {
        return $this->morphOne(File::class, 'fileable')->latest()->where('type', 'company_logo');
    }

    public function documentFile()
    {
        return $this->morphOne(File::class, 'fileable')->latest()->where('type', 'document');
    }

    public function address(){
        return $this->hasOne(Address::class,'job_post_id');
    }

    // public function job_applications(){
    //     return $this->hasMany(JobApplication::class);
    // }

    public function job_applications() {
        return $this->hasMany(UserApplication::class,'job_post_id');
    }

    public function sort_listed_applications() {
        return $this->hasMany(UserApplication::class,'job_post_id')->where('job_status','Interviewed');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }



        public function scopeWithFilters($query, $prices, $employment_status, $keyword=null,$location)
    {
        return $query
                ->when($keyword !=null && !$location,function($query) use ($keyword) {
                    $query->where("job_title","LIKE","%".$keyword."%");
                    $query->orwhere("company_name","LIKE","%".$keyword."%")->get();
                })
                ->when($keyword !=null && $location ,function($query) use ($keyword,$location) {
                    $query->where("job_title","LIKE","%".$keyword."%");
                    $query->orwhere("company_name","LIKE","%".$keyword."%");
                    $query->where("company_address","LIKE","%".$location."%")
                    ->get();
                })
                ->when($keyword ==null && $location ,function($query) use ($keyword,$location) {
                    // $query->where("job_title","LIKE","%".$keyword."%");
                    // $query->orwhere("company_name","LIKE","%".$keyword."%");
                    $query->where("company_address","LIKE","%".$location."%")
                    ->get();
                })
                ->when(request()->input('prices', []), function ($query) use ($prices){

                    $query->when(in_array(0, $prices), function ($query) {
                            $query->WhereBetween('min_salary', ['10000', '15000']);
                            $query->orWhereBetween('max_salary', ['15000', '20000']);
                        })
                        ->when(in_array(1, $prices), function ($query) {
                            $query->orWhereBetween('min_salary', ['20000', '29000']);
                            $query->orWhereBetween('max_salary', ['20000', '30000']);
                        })
                        ->when(in_array(2, $prices), function ($query) {
                            $query->orWhereBetween('min_salary', ['30000', '35000']);
                            $query->orWhereBetween('max_salary', ['30000', '40000']);
                        })
                        ->when(in_array(3, $prices), function ($query) {
                            $query->orWhereBetween('min_salary', ['40000', '45000']);
                            $query->orWhereBetween('max_salary', ['40000', '50000']);
                        });

                })

                ->when( request()->input('employment_status', []), function ($query) use ($employment_status) {

                    $query->when(in_array(0, $employment_status), function ($query) {

                        $query->orWhere("employment_status","LIKE","%"."Full Time"."%");
                        });
                    $query->when(in_array(1, $employment_status), function ($query) {

                        $query->orWhere("employment_status","LIKE","%"."Part Time"."%");
                        });
                    $query->when(in_array(2, $employment_status), function ($query) {

                        $query->orWhere("employment_status","LIKE","%"."Contractual"."%");
                        });
                    $query->when(in_array(3, $employment_status), function ($query) {

                        $query->orWhere("employment_status","LIKE","%"."Internship"."%");
                        });
                    $query->when(in_array(4, $employment_status), function ($query) {

                        $query->orWhere("employment_status","LIKE","%"."Freelance"."%");
                        });
                });
    }

}
