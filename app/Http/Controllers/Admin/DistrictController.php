<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DistrictRequest;
use App\Interfaces\DistrictInterface;
use App\Models\Division;
use App\Models\District;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    protected $district;

    public function __construct(DistrictInterface $district)
    {
        $this->district = $district;
        $this->middleware('auth');
    }

    protected function path(string $link)
    {
        return "admin.district.{$link}";
    }

    public function index()
    {
        if(request()->ajax()){
            $parameter_array = [
                'relations' =>['division']
            ];
            return $this->district->datatable($parameter_array);
        }
        return view($this->path('index'));
    }

    public function deletedListIndex()
    {
        if (request()->ajax()){
            $parameter_array = [
                'relations' =>['division']
            ];
            return $this->district->deletedDatatable($parameter_array);
        }
    }

    public function create()
    {
        $data['districts'] = District::pluck('bn_name','id');
        $data['divisions'] = Division::pluck('bn_name','id');
        /*$data['greater_districts'] = GreaterDistrict::pluck('bn_name','id');*/
        return view($this->path('create'))->with($data);
    }

    public function store(DistrictRequest $request)
    {
        return $this->district->create($request);
    }

    public function show(District $district)
    {
        //
    }

    public function edit(District $district)
    {
        $data['district'] = $district;
        $data['districts'] = District::pluck('name','id');
        $data['divisions'] = Division::pluck('bn_name','id');
        return view($this->path('edit'))->with($data);
    }

    public function update(DistrictRequest $request, District $district)
    {
        return $this->district->update($district->id,$request);
    }

    public function destroy(District $district)
    {
        return $this->district->delete($district->id);
    }

    public function restore($id)
    {
        return $this->district->restore($id);
    }

    public function forceDelete($id)
    {
        return $this->district->forceDelete($id);
    }

    public function status(Request $request)
    {
        return $this->district->status($request->id);
    }
}
