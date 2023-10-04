<?php

namespace App\Exports;

use App\Models\Alumni;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class AlumnisExport implements FromCollection, WithHeadings
{
    protected $alumnis;

    public function __construct($alumnis)
    {
        $this->alumnis = $alumnis;
    }

    public function headings(): array
    {
        return [
            'EWU ID', 'First Name', 'Middle Name', 'Last Name', 'Personal Email', 'University Email', 'Company Email', 'Personal contact number', 'NID', 'Date of Birth', 'Blood Group', 'Passing Year', 'Convocation Year', 'Organization', 'Designation/Department', 'Date of Join', 'Username', 'Login email',
        ];
    }

    public function collection()
    {
        $alumnis = Alumni::whereKey($this->alumnis)->select('alumnis.ewu_id_no', 'alumnis.first_name', 'alumnis.middle_name', 'alumnis.last_name', 'alumnis.personal_email', 'alumnis.university_email', 'alumnis.company_email', 'alumnis.personal_contact_number', 'alumnis.nid', 'alumnis.dob', 'alumnis.blood_group', 'alumnis.passing_year', 'alumnis.convocation_year', 'alumnis.organization', 'designation_department', 'alumnis.doj', 'users.username', 'users.email')
        ->join('users', 'alumnis.user_id', '=', 'users.id')
        ->get();

        return $alumnis;

        // return Alumni::whereKey($this->alumnis)->with('user')->select('ewu_id_no', 'first_name', 'middle_name', 'last_name', 'personal_email', 'university_email', 'company_email', 'personal_contact_number', 'nid', 'dob', 'blood_group', 'passing_year', 'convocation_year', 'organization', 'designation_department', 'doj')->get();
    }
}
