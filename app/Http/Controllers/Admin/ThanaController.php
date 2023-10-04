<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ThanaRequest;
use App\Interfaces\ThanaInterface;
use App\Models\District;
use App\Models\Division;
use App\Models\Thana;
use Illuminate\Http\Request;

class ThanaController extends Controller
{
    protected $thana;

    public function __construct(ThanaInterface $thana)
    {
        $this->thana = $thana;
        $this->middleware('auth');
    }

    protected function path(string $link){
        return "admin.thana.{$link}";
    }

    public function index(){
        if(request()->ajax()){
            $parameter_array = [
                'relations' =>['division', 'district']
            ];
            return $this->thana->datatable($parameter_array);
        }
        return view($this->path('index'));
    }

    public function deletedListIndex(){
        if (request()->ajax()){
            $parameter_array = [
                'relations' =>['division', 'district']
            ];
            return $this->thana->deletedDatatable($parameter_array);
        }
    }

    public function create()
    {
        $data['thanas'] = Thana::pluck('bn_name','id');
        $data['divisions'] = Division::pluck('bn_name','id');
        $data['districts'] = District::pluck('bn_name','id');
        return view($this->path('create'))->with($data);
    }

    public function store(ThanaRequest $request){
        return $this->thana->create($request);
    }

    public function show(Thana $thana)
    {
        //
    }

    public function edit(Thana $thana)
    {
        $data['thana'] = $thana;
        $data['thanas'] = Thana::pluck('name','id');
        $data['divisions'] = Division::pluck('bn_name','id');
        $data['districts'] = District::pluck('bn_name','id');
        return view($this->path('edit'))->with($data);
    }

    public function update(ThanaRequest $request, Thana $thana){
        return $this->thana->update($thana->id,$request);
    }

    public function destroy(Thana $thana){
        return $this->thana->delete($thana->id);
    }

    public function restore($id){
        return $this->thana->restore($id);
    }

    public function forceDelete($id){
        return $this->thana->forceDelete($id);
    }

    public function status(Request $request){
        return $this->thana->status($request->id);
    }
}
