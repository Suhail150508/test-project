<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\StudentWelfareRequest;
use App\Interfaces\StudentWelfareInterface;
use App\Models\StudentWelfare;
use App\Http\Resources\StudentWelfareCollection;

class StudentWelfareController extends Controller
{
    protected $student_welfare;

    public function __construct(StudentWelfareInterface $student_welfare)
    {
        $this->student_welfare = $student_welfare;
    }

    public function index()
    {
        if (request()->per_page){
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;

            $query = StudentWelfare::query()
                ->with('designation','student_welfare')
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orderBy('id', 'asc')
                ->paginate($perPage);

            return new StudentWelfareCollection($query);
        } else{
             $student_welfare = StudentWelfare::query()->with('designation','student_welfare')->where('status','Active')->paginate(8
             );
             return response()->json($student_welfare);
        }
    }


    public function deletedListIndex()
    {
        $deleted_list = $this->student_welfare->onlyTrashed();
        return response()->json($deleted_list);
    }

    public function store(StudentWelfareRequest $request)
    {
        $data = $request;
        $parameters = [
            'image_info' => [
                [
                    'type' => 'student_welfare',
                    'images' => $data->image,
                    'directory' => 'studentWelfare',
                    'input_field' => 'image',
                    'width' => '245',
                    'height' => '158',
                ],
            ],
        ];
        $student_welfare = $this->student_welfare->create($data, $parameters);

        return response()->json($student_welfare);
    }

    public function show(StudentWelfare $student_welfare)
    {
        $student_welfare = $this->student_welfare->findOrFail($student_welfare->id);
        return response()->json($student_welfare);
    }

    public function edit($id)
    {
        $student_welfare = $this->student_welfare->findOrFail($id);
        return response()->json($student_welfare);
    }

    public function update(StudentWelfareRequest $request, StudentWelfare $student_welfare)
    {
        $data = $request;
        $parameters = [
            'image_info' => [
                [
                    'type' => 'student_welfare',
                    'images' => $data->image,
                    'directory' => 'studentWelfare',
                    'input_field' => 'image',
                    'width' => '245',
                    'height' => '158',
                ],
            ],
        ];
        $student_welfare = $this->student_welfare->update($student_welfare->id, $data, $parameters);

        return response()->json($student_welfare);


//        $student_welfare = $this->student_welfare->update($student_welfare->id, $request);
//        return response()->json($student_welfare);
    }

    public function destroy($id)
    {
        $student_welfare = $this->student_welfare->delete($id);

        return response()->json([
            'message' => trans('student_welfare.deleted'),
        ], 200);
    }

    public function restore($id)
    {
        $student_welfare = $this->student_welfare->restore($id);
        return response()->json([
            'message' => trans('student_welfare.restored'),
        ], 200);
    }

    public function forceDelete($id)
    {
        $student_welfare = $this->student_welfare->forceDelete($id);
        return response()->json([
            'message' => trans('student_welfare.permanent_deleted'),
        ], 200);
    }

    public function status(Request $request)
    {
        $this->student_welfare->status($request->id);

        return response()->json([
            'message' => trans('student_welfare.status_updated'),
        ], 200);
    }
}
