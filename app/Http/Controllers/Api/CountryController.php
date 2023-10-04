<?php

namespace App\Http\Controllers\Api;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\CountryInterface;
use App\Http\Requests\Admin\CountryRequest;
use App\Http\Resources\CountryResource;
use App\Http\Resources\CountryCollection;

class CountryController extends Controller
{
    protected $country;

    public function __construct(CountryInterface $country)
    {
        $this->country = $country;
    }

    public function index()
    {
        if (!empty(request()->all())) {
            // If more than 0
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;

            $query = Country::query()
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orderBy('id', 'asc')
                ->paginate($perPage);

            return new CountryCollection($query);
        } else {
            // If 0
            $query = $this->country->get();

            return new CountryCollection($query);
        }
    }

    public function deletedListIndex()
    {
        $countries = $this->country->onlyTrashed();
        return response()->json($countries);
    }

    public function store(CountryRequest $request)
    {
        $country = $this->country->create($request);
        return new CountryResource($country);
    }

    public function show(Country $country)
    {
        $country = $this->country->findOrFail($country->id);
        return response()->json($country);
    }

    public function edit($id)
    {
        $country = $this->country->findOrFail($id);
        return response()->json($country);
    }

    public function update(CountryRequest $request, Country $country)
    {
        $country = $this->country->update($country->id, $request);
        $country['update'] = "update";
        return new CountryResource($country);
    }

    public function destroy(Country $country)
    {
        $country = $this->country->delete($country->id);
        return response()->json($country);
    }

    public function restore($id)
    {
        $country = $this->country->restore($id);
        return response()->json($country);
    }

    public function forceDelete($id)
    {
        $country = $this->country->forceDelete($id);
        return response()->json($country);
    }

    public function status(Request $request)
    {
        $country = $this->country->status($request->id);
        return response()->json($country);
    }

}
