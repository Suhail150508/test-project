<?php

namespace App\Http\Resources;

use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;

class EducationCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($education) {
                return [
                    'id' => $education->id,
                    'user_id' => $education->user_id,
                    'user_type' => $education->user_type,
                    'school' => $education->school,
                    'degree' => $education->degree,
                    'field_of_study' => $education->field_of_study,
                    'start_date' => $education->start_date,
                    'end_date' => $education->end_date,
                    'grade' => $education->grade,
                    'activities' => $education->activities,
                    'description' => $education->description,
                    'is_current' => $education->is_current,
                    'study_duration' => $this->studyDuration($education->start_date, $education->end_date)
                ];
            })
        ];
    }

    private function studyDuration($start_date, $end_date) {
        $startDate = Carbon::parse($start_date);
        $endDate = Carbon::parse($end_date);

        $time = $end_date ? $endDate->diff($startDate) : Carbon::now()->diff($startDate);
        // dd($time->y . ' Year ' . $time->m . ' Month ' . $time->d . ' Day');
        return $time->y . ' Year ' . $time->m . ' Month ' . $time->d . ' Day';
    }
}
