<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class EmployeeCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($employee) {
                return [
                    'id' => $employee->id,
                    'company_name' => $employee->company_name,
                    'status' => $employee->user->status,
                    'year_of_stablishment' => $employee->year_of_stablishment,
                    'company_size' => $employee->company_size,
                    'industry_type' => $employee->industry_type,
                    'contact_number' => $employee->contact_number,
                    'email' => $employee->email,
                    'division_id' => $employee->division_id,
                    'district_id' => $employee->district_id,
                    'thana_id' => $employee->thana_id,
                    'business' => $employee->business,
                    'website_url' => $employee->website_url,
                ];
            })
        ];
    }
}