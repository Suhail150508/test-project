<?php

namespace App\Exports;

use App\Models\UserApplication;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ApplicantListExport implements FromCollection, WithHeadings
{
    protected $applicants;

    public function __construct($applicants)
    {
        $this->applicants = $applicants;
    }

    public function headings(): array
    {
        return [
            'Full Name', 'Gender', 'Email', 'Special Qualfication', 'Job Title', 'Applyed Date',
        ];
    }

    public function collection()
    {
        // $applicants = UserApplication::whereKey($this->applicants)
        //             ->select('resumes.first_name', 'resumes.middle_name', 'resumes.last_name', 'resumes.gender', 'resumes.email', 'resumes.special_qualfication', 'job_posts.job_title', 'user_applications.applyed_date')
        //             ->join('resumes', 'user_applications.resume_id', '=', 'resumes.id')
        //             ->join('job_posts', 'user_applications.job_post_id', '=', 'job_posts.id')
        //             ->get();

        // return $applicants;

        $applicants = UserApplication::whereKey($this->applicants)
                    ->selectRaw("CONCAT(resumes.first_name, ' ', resumes.middle_name, ' ', resumes.last_name) AS full_name, resumes.gender, resumes.email, resumes.special_qualification, job_posts.job_title, DATE_FORMAT(user_applications.applyed_date, '%d-%m-%Y') AS formatted_date")
                    ->join('resumes', 'user_applications.resume_id', '=', 'resumes.id')
                    ->join('job_posts', 'user_applications.job_post_id', '=', 'job_posts.id')
                    ->get();

        return $applicants;
    }
}
