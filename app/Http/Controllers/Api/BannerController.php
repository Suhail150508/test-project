<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\BannerRequest;
use App\Interfaces\BannerInterface;
use App\Models\Banner;
use App\Http\Resources\BannerCollection;

class BannerController extends Controller
{
    protected $banner;

    public function __construct(BannerInterface $banner)
    {
        $this->banner = $banner;
    }

    public function index()
    {
        
        $perPage = request()->per_page;
        $fieldName = request()->field_name;
        $keyword = request()->keyword;

        $query = Banner::query()
            ->where($fieldName, 'LIKE', "%$keyword%")
            ->orderBy('id', 'asc')
            ->paginate($perPage);

        return new BannerCollection($query);
    }


    public function deletedListIndex()
    {
        $deleted_list = $this->banner->onlyTrashed();
        return response()->json($deleted_list);
    }

    public function store(BannerRequest $request)
    {
        $banner = $this->banner->create($request);
        return response()->json($banner);
    }

    public function edit($id)
    {
        $banner = $this->banner->findOrFail($id);
        return response()->json($banner);
    }

    public function update(BannerRequest $request, Banner $banner)
    {
        $banner = $this->banner->update($banner->id, $request);
        return response()->json($banner);
    }

    public function destroy($id)
    {
        $banner = $this->banner->delete($id);
        return response()->json($banner);
    }

    public function restore($id)
    {
        $banner = $this->banner->restore($id);
        return response()->json($banner);
    }

    public function forceDelete($id)
    {
        $banner = $this->banner->forceDelete($id);
        return response()->json($banner);
    }

    public function status(Request $request)
    {
        return $this->banner->status($request->id);
    }
}
