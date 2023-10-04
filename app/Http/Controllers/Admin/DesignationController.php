<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ModalHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DesignationRequest;
use App\Interfaces\DesignationInterface;
use App\Models\Designation;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    protected $designation;

    public function __construct(DesignationInterface $designation)
    {
        $this->designation = $designation;
        $this->middleware('auth');
    }

    protected function path(string $link)
    {
        return "admin.designation.{$link}";
    }

    public function index()
    {
        if(request()->ajax()){
            return $this->designation->datatable();
        }else{
            return view($this->path('index'));
        }
    }

    public function deletedListIndex()
    {
        if (request()->ajax()){
            return $this->designation->deletedDatatable();
        }
    }

    public function create()
    {
        $data = [
            'title' => trans('common.create',['model' => trans('designation.designation')]),
            'form_action' => route('designation.store'),
            'method' => 'post',
            'included_path' => 'admin.designation.form',
        ];

        return ModalHelper::content($data);
    }

    public function store(DesignationRequest $request)
    {
        return $this->designation->create($request);
    }

    public function show(Designation $designation)
    {
        //
    }

    public function edit(Designation $designation)
    {
        $data = [
            'title' => trans('common.edit',['model' => trans('designation.designation')]),
            'form_action' => route('designation.update',$designation->id),
            'method' => 'patch',
            'model' => $designation,
            'included_path' => 'admin.designation.form',
        ];

        return ModalHelper::content($data);
    }

    public function update(DesignationRequest $request, Designation $designation)
    {

    }

    public function destroy(Designation $designation)
    {
        return $this->designation->delete($designation->id);
    }

    public function restore($id)
    {
        return $this->designation->restore($id);
    }

    public function forceDelete($id)
    {
        return $this->designation->forceDelete($id);
    }

    public function status(Request $request)
    {
        return $this->designation->status($request->id);
    }
}
