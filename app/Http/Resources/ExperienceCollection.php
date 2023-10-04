<?php

namespace App\Http\Resources;

use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ExperienceCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($experience) {
                return [
                    'id' => $experience->id,
                    'user_id' => $experience->user_id,
                    'user_type' => $experience->user_type,
                    'title' => $experience->title,
                    'employment_type' => $experience->employment_type,
                    'company_name' => $experience->company_name,
                    'designation_department' => $experience->designation_department,
                    'country_id' => $experience->country_id,
                    'country' => $experience->country,
                    // 'division' => $experience->division_id,
                    'district_id' => $experience->district_id,
                    'district' => $experience->district,
                    'location_type' => $experience->location_type,
                    'start_date' => $experience->start_date,
                    'end_date' => $experience->end_date,
                    'is_current' => $experience->is_current,
                    'description' => $experience->description,
                    'industry' => $experience->industry,
                    'experience' => $this->experience($experience->start_date, $experience->end_date)
                ];
            })
        ];
    }

    private function experience($start_date, $end_date)
    {
        $startDate = Carbon::parse($start_date);
        $endDate = Carbon::parse($end_date);

        $time = $end_date ? $endDate->diff($startDate) : Carbon::now()->diff($startDate);
        // dd($time->y . ' Year ' . $time->m . ' Month ' . $time->d . ' Day');
        return $time->y . ' Year ' . $time->m . ' Month ' . $time->d . ' Day';
    }
}
