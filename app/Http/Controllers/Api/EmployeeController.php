<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ModalHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EmployeeRequest;
use App\Http\Resources\EmployeeCollection;
use App\Interfaces\DesignationInterface;
use App\Interfaces\EmployeeInterface;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\User;
use App\Models\Resume;
use Hash;
use DB;


class EmployeeController extends Controller
{
    protected $employee;
    protected $designation;

    public function __construct(EmployeeInterface $employee)
    {
        $this->employee = $employee;
    }

    protected function path(string $link)
    {
        return "admin.employee.{$link}";
    }

    public function index()
    {
        if (request()->per_page) {
            // If more than 0
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;
            $query = Employee::query()

            ->orderBy('id', 'desc')
            ->with('user')
            ->paginate($perPage);
            return new EmployeeCollection($query);
        }
    }

    public function deletedListIndex()
    {
        if (request()->ajax()){
            $parameter_array = [
                'relations' =>['designation','fire_station']
            ];
            return $this->employee->deletedDatatable($parameter_array);
        }
    }

    public function create()
    {
        $data['designations'] = $this->designation->pluck();
        $data['religions'] = Employee::religions();
        $data['genders'] = Employee::genders();
        $data['employees'] = $this->employee->pluck();

        return view($this->path('create'))->with($data);
    }

    public function store(EmployeeRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();
            $data['password'] = Hash::make($request->password);
            $data['employment_status'] = "Company";
            $user = User::create($data);      //created auth user
            $data['user_id'] = $user->id;
            $employee =  Employee::create($data); //inserted data on Employee table
            $resume =  Resume::create($data); //inserted data on Resume table
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'User created successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ],200);
            // }


        }
        catch (\Exception $e) {
            // An error occured; cancel the transaction...
            DB::rollback();

            // and throw the error again.
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $e->getMessage()
            ],500);
        }

        return $this->employee->create($data,$parameters);
    }
        //Employee approval
        public function EmployeeApproval($user_id)
        {
            $employee = Employee::where('id', $user_id)->first();
            $user = User::where('id', $employee->user_id)->first();
            if ($user->status == "Inactive") {
                $user->update([
                    'status' => "Active"
                ]);
            } else {
                $user->update([
                    'status' => "Inactive"
                ]);
            }
            return response()->json([
                "success" => trans('Employee.approved'),
                "data" => $user
            ],200);

            /*$jobPost = JobPost::query()->findOrFail($id);
            if ($jobPost->is_approved == "No"){
                $jobPost->update(["is_approved" => "Yes"]);

                // mail-notification for job post creator after approval
                $jobPost->user->notify(new CreatorJobPostApproved($jobPost));

                //start mail-notification for related job-seekers
                $needToNotifyUser = Collection::empty();
                $seekers = User::query()->where('employment_status','Job-Seeker')->get();

                foreach ($jobPost->department_ids as $department_id) {
                    foreach ($seekers as $seeker){
                        if ($seeker->alumni_id){
                            if ($seeker->alumni->department_id == $department_id)
                                $needToNotifyUser[$seeker->id] = $seeker;
                        }elseif($seeker->student_id){
                            if ($seeker->student->department_id == $department_id)
                                $needToNotifyUser[$seeker->id] = $seeker;
                        }
                    }
                }

                foreach ($needToNotifyUser as $user){
                    Notification::route('mail',$user->email)->notify(new NewJobNotify($jobPost));
                }

                //end mail-notification for related job-seekers


                return response()->json([
                    "success" => trans('jobPost.approved')
                ],200);
            } else{

                return response()->json([
                    "info" => trans('jobPost.already_approved')
                ],208);
            }*/
        }

    public function show(Employee $employee)
    {
        //
    }

    public function edit(Employee $employee)
    {
        $data['employee'] = $employee;
        $data['designations'] = $this->designation->pluck();
        $data['religions'] = Employee::religions();
        $data['genders'] = Employee::genders();
        $data['employees'] = $this->employee->pluck();
        return view($this->path('edit'))->with($data);
    }

    public function update(Request $request, Employee $job_employeer)
    {
        // dd($job_employeer);
        $data = $request;
        $data['birth_date'] = date('Y-m-d',strtotime($request->birth_date));
        if ($data['remove_profile_picture'] == 'on') {$data['profile_picture'] = '';}
        if ($data['remove_signature'] == 'on') {$data['signature'] = '';}

        $parameters = [
            'image_info' => [
                [
                    'type' => 'profile_picture',
                    'images' => $data->profile_picture,
                    'directory' => 'profile_pictures',
                    'input_field' => 'profile_picture',
                    'width' => '',
                    'height' => '',
                ],
                [
                    'type' => 'signature',
                    'images' => $data->signature,
                    'directory' => 'signatures',
                    'input_field' => 'signature',
                    'width' => '',
                    'height' => '',
                ],
            ],
        ];

        return $this->employee->update($employee->id,$data,$parameters);
    }

    public function destroy(Employee $employee)
    {
        return $this->employee->delete($employee->id);
    }

    public function restore($id)
    {
        return $this->employee->restore($id);
    }

    public function forceDelete($id)
    {
        return $this->employee->forceDelete($id);
    }

}
