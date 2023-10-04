<?php

namespace App\Http\Controllers\Api;

use App\Models\Education;
use App\Models\Institute;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\EducationInterface;
use App\Http\Resources\EducationResource;
use App\Http\Resources\EducationCollection;
use App\Http\Requests\Admin\EducationRequest;

class EducationController extends Controller
{
    protected $education;

    public function __construct(EducationInterface $education)
    {
        $this->education = $education;
    }

    public function index()
    {
        // return request()->all();
        $query = Education::query()
            ->where('user_id', request()->user_id)
            ->where('user_type', request()->user_type)
            ->orderBy('is_current', 'ASC')
            ->get();

        return new EducationCollection($query);
    }

    public function create()
    {
        //
    }

    public function store(EducationRequest $request)
    {
//         dd($request->all());
         if ($request->job){
             if ($request->jsc_examination) {
                 $education = new Education();
                 $education->user_id = $request->user_id;
                 $education->resume_id = $request->resume_id;
                 $education->user_type = 'resumes';
            //  $education->employee_id = $employee->id;
                 $education->type = 'jsc';
                 $education->degree = $request->jsc_examination;
                 $education->board = $request->jsc_board;
                 $education->roll = $request->jsc_roll;
                 if (!($request->jsc_result == 4 || $request->jsc_result == 5)) {
                     $education->grade = $request->jsc_result;
                 } else {
                     $education->grade = $request->jsc_gpa;
                 }
                 $education->passing_year = $request->jsc_passing_year;
                 $education->school = $request->jsc_institute;

                 $education->save();
             }

             if ($request->ssc_examination) {
                 $education = new Education();
                 $education->user_id = $request->user_id;
                 $education->resume_id = $request->resume_id;
                 $education->user_type = 'resumes';
                // $education->employee_id = $employee->id;
                 $education->type = 'ssc';
                 $education->degree = $request->ssc_examination;
                 $education->board = $request->ssc_board;
                 $education->roll = $request->ssc_roll;
                 if (!($request->ssc_result == 4 || $request->ssc_result == 5)) {
                     $education->grade = $request->ssc_result;
                 } else {
                     $education->grade = $request->ssc_gpa;
                 }
                 $education->field_of_study = $request->ssc_subject;
                 $education->passing_year = $request->ssc_passing_year;
                 $education->school = $request->ssc_institute;

                 $education->save();
             }

             if ($request->hsc_examination) {
                 $education = new Education();
                 $education->user_id = $request->user_id;
                 $education->resume_id = $request->resume_id;
                 $education->user_type = 'resumes';
                 // $education->employee_id = $employee->id;
                 $education->type = 'hsc';
                 $education->degree = $request->hsc_examination;
                 $education->board = $request->hsc_board;
                 $education->roll = $request->hsc_roll;
                 if (!($request->hsc_result == 4 || $request->hsc_result == 5)) {
                     $education->grade = $request->hsc_result;
                 } else {
                     $education->grade = $request->hsc_gpa;
                 }
                 $education->field_of_study = $request->hsc_subject;
                 $education->passing_year = $request->hsc_passing_year;
                 $education->school = $request->hsc_institute;

                 $education->save();
             }

             if ($request->graduation_examination) {
                 $education = new Education();

                 $education->user_id = $request->user_id;
                 $education->major_subject_id  = $request->major_subject_id ;
                 $education->minor_subject_id  = $request->minor_subject_id ;
                 $education->resume_id = $request->resume_id;
                 $education->user_type = 'resumes';
                 /*if ($request->graduation_institute) {
                     if (Institute::where('type', 'Graduation')->where('name', $request->graduation_institute)->get()->isEmpty()) {
                         Institute::create([
                             'name' => $request->graduation_institute,
                             'type' => 'Graduation',
                         ]);
                     }
                 }*/

                 // $education->employee_id = $employee->id;
                 $education->type = 'graduation';
                 $education->degree = $request->graduation_examination;
                 $education->duration = $request->graduation_course_duration;
                 if (!($request->graduation_result == 4 || $request->graduation_result == 5)) {
                     $education->grade = $request->graduation_result;
                 } else {
                     $education->grade = $request->graduation_gpa;
                 }
                 $education->field_of_study = $request->graduation_subject;
                 $education->passing_year = $request->graduation_passing_year;
                 $education->school = $request->graduation_institute;

                 $education->save();
             }

             if ($request->masters_examination) {
                 $education = new Education();

                 /*if ($request->masters_institute) {
                     if (Institute::where('type', 'Masters')->where('name', $request->masters_institute)->get()->isEmpty()) {
                         Institute::create([
                             'name' => $request->masters_institute,
                             'type' => 'Masters',
                         ]);
                     }
                 }*/

                 $education->user_id = $request->user_id;
                 $education->resume_id = $request->resume_id;
                 $education->user_type = 'resumes';
                 // $education->employee_id = $employee->id;
                 $education->type = 'masters';
                 $education->degree = $request->masters_examination;
                 $education->duration = $request->masters_course_duration;
                 if (!($request->masters_result == 4 || $request->masters_result == 5)) {
                     $education->grade = $request->masters_result;
                 } else {
                     $education->grade = $request->masters_gpa;
                 }
                 $education->field_of_study = $request->masters_subject;
                 $education->passing_year = $request->masters_passing_year;
                 $education->school = $request->masters_institute;

                 $education->save();
             }

         } else{
             $education = $this->education->create($request);
         }
        return new EducationResource($education);
    }

    public function show($id)
    {
        $education = Education::query()->where('user_type','resumes')->where('user_id',$id)->get();

        return response()->json($education);
    }

    public function edit(Education $education)
    {
        //
    }

    public function update(EducationRequest $request, Education $education)
    {
        $education = $this->education->update($education->id, $request);
        $request['update'] = "update";
        return new EducationResource($education);
    }

    public function updateFromJob(EducationRequest $request,$userId)
    {
        $educations = Education::query()->where('user_type','resumes')->where('user_id',$userId)->get();

        foreach ($educations as $key=>$education){

            if ($request->jsc_examination && $education->type == 'jsc') {
                $education->degree = $request->jsc_examination;
                $education->board = $request->jsc_board;
                $education->roll = $request->jsc_roll;
                if (!($request->jsc_result == 4 || $request->jsc_result == 5)) {
                    $education->grade = $request->jsc_result;
                } else {
                    $education->grade = $request->jsc_gpa;
                }
                $education->passing_year = $request->jsc_passing_year;
                $education->school = $request->jsc_institute;

                $education->save();
            }

            if ($request->ssc_examination  && $education->type == 'ssc') {
                $education->degree = $request->ssc_examination;
                $education->board = $request->ssc_board;
                $education->roll = $request->ssc_roll;
                if (!($request->ssc_result == 4 || $request->ssc_result == 5)) {
                    $education->grade = $request->ssc_result;
                } else {
                    $education->grade = $request->ssc_gpa;
                }
                $education->field_of_study = $request->ssc_subject;
                $education->passing_year = $request->ssc_passing_year;
                $education->school = $request->ssc_institute;

                $education->save();
            }

            if ($request->hsc_examination  && $education->type == 'hsc') {
                $education->degree = $request->hsc_examination;
                $education->board = $request->hsc_board;
                $education->roll = $request->hsc_roll;
                if (!($request->hsc_result == 4 || $request->hsc_result == 5)) {
                    $education->grade = $request->hsc_result;
                } else {
                    $education->grade = $request->hsc_gpa;
                }
                $education->field_of_study = $request->hsc_subject;
                $education->passing_year = $request->hsc_passing_year;
                $education->school = $request->hsc_institute;

                $education->save();
            }

            if ($request->graduation_examination  && $education->type == 'graduation') {
                $education->degree = $request->graduation_examination;
                $education->duration = $request->graduation_course_duration;
                if (!($request->graduation_result == 4 || $request->graduation_result == 5)) {
                    $education->grade = $request->graduation_result;
                } else {
                    $education->grade = $request->graduation_gpa;
                }
                $education->field_of_study = $request->graduation_subject;
                $education->passing_year = $request->graduation_passing_year;
                $education->school = $request->graduation_institute;
                $education->major_subject_id  = $request->major_subject_id ;
                $education->minor_subject_id  = $request->minor_subject_id ;

                $education->save();
            }

            if ($request->masters_examination  && $education->type == 'masters') {
                $education->degree = $request->masters_examination;
                $education->duration = $request->masters_course_duration;
                if (!($request->masters_result == 4 || $request->masters_result == 5)) {
                    $education->grade = $request->masters_result;
                } else {
                    $education->grade = $request->masters_gpa;
                }
                $education->field_of_study = $request->masters_subject;
                $education->passing_year = $request->masters_passing_year;
                $education->school = $request->masters_institute;

                $education->save();
            }
        }

        return new EducationResource($education);
    }

    public function destroy(Education $education)
    {
        // dd($education->id);
        $education = $this->education->delete($education->id);
        return response()->json($education);
    }
}
