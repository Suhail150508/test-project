<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\DivisionRequest;
use App\Interfaces\DivisionInterface;
use App\Models\Division;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    protected $division;

    public function __construct(DivisionInterface $division)
    {
        $this->division = $division;
        $this->middleware('auth');
    }

    protected function path(string $link)
    {
        return "admin.division.{$link}";
    }

    public function index()
    {
        if(request()->ajax())
        {
            return $this->division->datatable();
        }else{
            return view($this->path('index'));
        }

    }

    public function deletedListIndex()
    {
        if (request()->ajax()){
            return $this->division->deletedDatatable();
        }
    }

    public function create()
    {
        $data['divisions'] = $this->division->pluck('bn_name','id');
        return view($this->path('create'))->with($data);
    }

    public function store(DivisionRequest $request)
    {
        return $this->division->create($request);
    }

    public function show(Division $division)
    {
        //
    }

    public function edit(Division $division)
    {
        $data['division'] = $division;
        $data['divisions'] = $this->division->pluck('name','id');
        return view($this->path('edit'))->with($data);
    }

    public function update(DivisionRequest $request, Division $division)
    {
        return $this->division->update($division->id,$request);
    }

    public function destroy(Division $division)
    {
        return $this->division->delete($division->id);
    }

    public function restore($id)
    {
        return $this->division->restore($id);
    }

    public function forceDelete($id)
    {
        return $this->division->forceDelete($id);
    }

    public function status(Request $request)
    {
        return $this->division->status($request->id);
    }
}
