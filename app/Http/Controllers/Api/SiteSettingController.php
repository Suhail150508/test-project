<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\SiteSettingInterface;
use App\Http\Requests\Admin\SiteSettingRequest;
use App\Http\Resources\SiteSettingCollection;
use App\Models\SiteSetting;

class SiteSettingController extends Controller
{
    protected $sitesetting;

    public function __construct(SiteSettingInterface $sitesetting)
    {
        $this->sitesetting = $sitesetting;
    }

    public function index()
    {  
        $perPage = request()->per_page;
        $fieldName = request()->field_name;
        $keyword = request()->keyword;

        $query = SiteSetting::query()
            ->where($fieldName, 'LIKE', "%$keyword%")
            ->orderBy('id', 'asc')
            ->paginate($perPage);

        return new SiteSettingCollection($query);
    }

    public function deletedListIndex()
    {
        $deleted_list = $this->sitesetting->onlyTrashed();
        return response()->json($deleted_list);
    }

    public function store(SiteSettingRequest $request)
    {
        $sitesetting = $this->sitesetting->create($request);
        return response()->json($sitesetting);
    }

    public function show($id)
    {
        $sitesetting = $this->sitesetting->findOrFail($id);
        return response()->json($sitesetting);
    }

    public function edit($id)
    {
        $sitesetting = $this->sitesetting->findOrFail($id);
        return response()->json($sitesetting);
    }

    public function update(SiteSettingRequest $request, $id)
    {
        $sitesetting = $this->sitesetting->update($id,$request);
        return response()->json($sitesetting);
    }

    public function destroy($id)
    {
        $sitesetting = $this->sitesetting->delete($id);
        return response()->json($sitesetting);
    }

    public function restore($id)
    {
        return $this->sitesetting->restore($id);
    }

    public function forceDelete($id)
    {
        return $this->sitesetting->forceDelete($id);
    }

    public function status(Request $request)
    {
        return $this->sitesetting->status($request->id);
    }
}