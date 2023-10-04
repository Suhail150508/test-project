<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProCertificationCollection;
use App\Interfaces\ProfessionalCertificationInterface;
use App\Http\Requests\Admin\ProfessionalCertificationRequest;
use App\Models\ProfessionalCertification;
use Illuminate\Http\Request;

class ProfessionalCertificationController extends Controller
{
    protected $professional_certification;

    public function __construct(ProfessionalCertificationInterface $professional_certification)
    {
        $this->professional_certification = $professional_certification;
    }
    public function index()
    {
        $perPage = request()->per_page;
        $fieldName = request()->field_name;
        $keyword = request()->keyword;

        $query = ProfessionalCertification::query()
            ->where($fieldName, 'LIKE', "%$keyword%")
            ->orderBy('id', 'asc')
            ->paginate($perPage);

        return new ProCertificationCollection($query);
    }

    public function userCertificaion($resume_id) {
        $userCertificaions = ProfessionalCertification::where('resume_id',$resume_id)->get();
        return response()->json($userCertificaions);
    }

    public function deletedListIndex()
    {
        $deleted_list = $this->professional_certification->onlyTrashed();

        return response()->json([
            'data ' => $deleted_list
        ], 200);
    }

    public function store(ProfessionalCertificationRequest $request)
    {
        $professionalcertification = $this->professional_certification->create($request);

        return response()->json([
            'data' => $professionalcertification,
            'message' => trans('professional_certification.created'),
        ], 200);
    }

    public function show(ProfessionalCertification $professional_certification)
    {
        $professional_certification = ProfessionalCertification::findOrFail($professional_certification->id);

        return response()->json([
            'data' => $professional_certification
        ], 200);
    }

    public function edit($id)
    {
        $professional_certification = $this->professional_certification->findOrFail($id);
        return response()->json($professional_certification);
    }

    public function update(ProfessionalCertificationRequest $request, ProfessionalCertification $professional_certification)
    {
        $professional_certification = $this->professional_certification->update($professional_certification->id,$request);

        return response()->json([
            'data' => $professional_certification,
            'message' => trans('professional_certification.updated'),
        ], 200);
    }

    public function destroy(ProfessionalCertification $professional_certification)
    {
        $professional_certification = $this->professional_certification->delete($professional_certification->id);

        return response()->json([
            'data' => $professional_certification,
            'message' => trans('professional_certification.deleted'),
        ], 200);
    }

    public function restore($id)
    {
        $professional_certification = $this->professional_certification->restore($id);

        return response()->json([
            'message' => trans('professional_certification.restore'),
        ], 200);
    }

    public function forceDelete($id)
    {
        $professional_certification = $this->professional_certification->forceDelete($id);

        return response()->json([
            'message' => trans('professional_certification.forcedelete'),
        ], 200);
    }

    public function status(Request $request)
    {
        $professional_certification = $this->professional_certification->status($request->id);

        return response()->json([
            'message' => trans('professional_certification.status'),
        ], 200);
    }
}
