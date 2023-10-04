<?php

namespace App\Exports;

use App\Models\Resume;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class JobApplicantExport implements FromCollection, WithHeadings
{
    protected $resume;

    public function __construct($resume)
    {
        $this->resume = $resume;
    }

    public function headings(): array
    {
        return [
            'EWU ID', 'First Name', 'Middle Name', 'Birthdate', 'Gender', 'Religion', 'Email',
        ];
    }

    public function collection()
    {
        $resume = Resume::whereKey($this->resume)->select(['ewu_id_no','first_name','middle_name','birthdate','gender','religion','email'])
        // ->join('users', 'resumes.user_id', '=', 'users.id')
        ->get();

        return $resume;

        // return Alumni::whereKey($this->alumnis)->with('user')->select('ewu_id_no', 'first_name', 'middle_name', 'last_name', 'personal_email', 'university_email', 'company_email', 'personal_contact_number', 'nid', 'dob', 'blood_group', 'passing_year', 'convocation_year', 'organization', 'designation_department', 'doj')->get();
    }
}
