<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StudentFeedbackRequest;
use App\Http\Resources\StudentFeedbackCollection;
use App\Interfaces\StudentFeedbackInterface;
use App\Models\StudentFeedback;
use Illuminate\Http\Request;

class StudentFeedbackController extends Controller
{
    protected $student_feedback;

    public function __construct(StudentFeedbackInterface $student_feedback)
    {
        $this->student_feedback = $student_feedback;
    }

    public function index()
    {
        if (request()->per_page) {
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;

            $query = StudentFeedback::query()
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orderBy('id', 'DESC')
                ->paginate($perPage);

            return new StudentFeedbackCollection($query);
        } else {
            $student_feedback = StudentFeedback::query()->paginate(10);

            return response()->json($student_feedback);
        }
    }

    public function studentFeedbackDeletedList()
    {
        if (request()->per_page) {
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;

            $query = StudentFeedback::query()
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orderBy('id', 'DESC')
                ->onlyTrashed()
                ->paginate($perPage);

            return new StudentFeedbackCollection($query);
        } else {
            $query = StudentFeedback::query()->onlyTrashed()->get();

            return new StudentFeedbackCollection($query);
        }
    }

    public function create()
    {

    }

    public function store(StudentFeedbackRequest $request)
    {
        $data = $request;
        $student_feedback = $this->student_feedback->create($data);

        return response()->json($student_feedback);
    }

    public function show(StudentFeedback $studentFeedback)
    {
        $query = $this->student_feedback->findOrFail($studentFeedback->id);

        return response()->json($query);
    }

    public function edit(StudentFeedback $studentFeedback)
    {

    }

    public function update(Request $request, StudentFeedback $studentFeedback)
    {

    }

    public function destroy(StudentFeedback $studentFeedback)
    {
        $this->student_feedback->delete($studentFeedback->id);

        return response()->json([
            'message' => 'Student feedback successfully deleted',
        ], 200);
    }

    public function restore($id)
    {
        $this->student_feedback->restore($id);

        return response()->json([
            'message' => "Student feedback restored successfully",
        ], 200);
    }

    public function forceDelete($id)
    {
        $this->student_feedback->forceDelete($id);

        return response()->json([
            'message' => "Student feedback permanently deleted",
        ], 200);
    }
}
