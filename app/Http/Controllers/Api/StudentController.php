<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StudentRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\StudentResource;
use App\Interfaces\StudentInterface;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\User;
use App\Models\Address;





class StudentController extends Controller
{
    protected $student;

    public function __construct(StudentInterface $student){
        $this->student = $student;
    }
    public function index()
    {
        $students = $this->student->with(['user','addresses'])->get();
        return response()->json($students);
    }


    public function deletedListIndex()
    {
        $students = $this->student->onlyTrashed();
        return response()->json($students);
    }

    public function store(StudentRequest $request)
    {
        $data = $request;
        $userInfos = $request->userInfos;
        $userInfos['password'] = Hash::make($request->userInfos['password']);
        $addresses = $request->address;
        $parameters = [
            'create_single' => [
                [
                    'relation' => 'user',
                    'data' => $userInfos,
                ],
            ],
            'create_many' => [
                [
                    'relation' => 'addresses',
                    'data' => $addresses
                ],
            ],
        ];
        $student = $this->student->create($data, $parameters);

        return response()->json([
            'data' => $student,
            'message' => trans('studnet.created'),
        ], 200);
    }


    public function show(Student $student)
    {
        $student = $this->student->with(['user'])->findOrFail($student->id);
        return response()->json($student);
    }

    public function edit($id)
    {
        $student = $this->student->findOrFail($id);
        return response()->json($student);
    }

    public function update(StudentRequest $request, Student $student)
    {
        $data = $request;
        $userInfos = $request->userInfos;
        $userInfos['password'] = Hash::make($request->userInfos['password']);
        $addresses = $request->address;

        $parameters = [
            'update_single' => [
                [
                    'relation' => 'user',
                    'data' => $userInfos,
                ],
            ],
            'create_many' => [
                [
                    'relation' => 'addresses',
                    'data' => $addresses
                ],
            ],
        ];

        $student = $this->student->update($student->id, $data, $parameters);

        return response()->json([
            'data' => $student,
            'message' => trans('student.updated'),
        ], 200);
    }

    public function destroy(Student $student)
    {
      
        $this->student->delete($student->id);
        if (isset($student->user)) {
            $student->user->delete();
        }
        if (isset($student->addresses)) {
            foreach($student->addresses as $address) {
                $address->delete();
            }
        }

        return response()->json([
            'message' => trans('student.deleted'),
        ], 200);
    }

    public function restore($id)
    {
        $this->student->restore($id);
        $trashed_user = User::onlyTrashed()->where('student_id', $id)->first();
        if ($trashed_user != null) {
            $trashed_user->restore();
        }

        $trashed_addesses = Address::onlyTrashed()->where('student_id',$id)->get();
        if ($trashed_addesses->isNotEmpty()) {
            foreach($trashed_addesses as $item) {
                if($item != null) {
                 $item->restore();
                }
             }
        };
      
        return response()->json([
            'message' => trans('student.restored'),
        ], 200);
    }


    public function forceDelete($id)
    {
        return $this->student->forceDelete($id); 
    }


    public function status(Request $request)
    {
        return $this->student->status($request->id);
    }
}
