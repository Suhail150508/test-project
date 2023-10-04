<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CountryRequest;
use App\Interfaces\CountryInterface;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    protected $country;

    public function __construct(CountryInterface $country)
    {
        $this->country = $country;
        $this->middleware('auth');
    }

    protected function path(string $link)
    {
        return "admin.country.{$link}";
    }

    public function index()
    {
        if(request()->ajax()){
            return $this->country->datatable();
        }
        return view($this->path('index'));
    }

    public function deletedListIndex()
    {
        if (request()->ajax()){
            return $this->country->deletedDatatable();
        }
    }

    public function create()
    {
        $data['countries'] = $this->country->pluck();
        return view($this->path('create'))->with($data);
    }

    public function store(CountryRequest $request)
    {
        return $this->country->create($request);
    }

    public function show(Country $country)
    {
        //
    }

    public function edit(Country $country)
    {
        $data['country'] = $country;
        $data['countries'] = $this->country->pluck();
        return view($this->path('edit'))->with($data);
    }

    public function update(CountryRequest $request, Country $country)
    {
        return $this->country->update($country->id,$request);
    }

    public function destroy(Country $country)
    {
        return $this->country->delete($country->id);
    }

    public function restore($id)
    {
        return $this->country->restore($id);
    }

    public function forceDelete($id)
    {
        return $this->country->forceDelete($id);
    }

    public function status(Request $request)
    {
        return $this->country->status($request->id);
    }

}
