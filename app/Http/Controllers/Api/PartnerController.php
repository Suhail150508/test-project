<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PartnerRequest;
use App\Http\Resources\PartnerCollection;
use App\Interfaces\PartnerInterface;
use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{

    protected $partner;

    public function __construct(PartnerInterface $partner)
    {
        $this->partner=$partner;
    }

    public function index()
    {
        if (request()->per_page) {
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;

            $query = Partner::query()
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orderBy('id', 'asc')
                ->paginate($perPage);

            return new PartnerCollection($query);
        }else{
            $partner = Partner::query()->orderBy('order_place', 'asc')->get();
            return new PartnerCollection($partner);
        }
    }

    public function deletedListIndex()
    {
        $partner = $this->partner->onlyTrashed();

        return response()->json($partner);
    }


    public function store(PartnerRequest $request)
    {
        /*$partner = $this->partner->create($request);
        return response()->json(['data' => $partner, 'message' => trans('partner.created'),], 200);*/
        $data = $request;
        $parameters = [
            'image_info' => [
                [
                    'type' => 'partner',
                    'images' => $data->image,
                    'directory' => 'partner',
                    'input_field' => 'image',
                    'width' => '',
                    'height' => '',
                ],
            ],
        ];
        $partner = $this->partner->create($data, $parameters);

        return response()->json([
            'data' => $partner,
            'message' => 'Partners Created Successfully',
        ], 200);
    }

    public function show(Partner $partner)
    {
        $partner = $this->partner->findOrFail($partner->id);
        $partner['image'] =  $partner->partner->source;
        return response()->json($partner);
    }

    public function edit($id)
    {
        $partner = $this->partner->findOrFail($id);

        return response()->json($partner);
    }

    public function update(PartnerRequest $request, Partner $partner)
    {
        $data = $request;
        $parameters = [
            'image_info' => [
                [
                    'type' => 'partner',
                    'images' => $data->image,
                    'directory' => 'partner',
                    'input_field' => 'image',
                    'width' => '',
                    'height' => '',
                ],
            ],
        ];

        $partner = $this->partner->update($partner->id,$data,$parameters);

        $request['update'] = 'update';

        return response()->json([
            'data' => $partner,
            'message' => trans('partner.updated'),
        ], 200);
    }

    public function destroy(Partner $partner)
    {
        $this->partner->delete($partner->id);

        return response()->json([
            'message' => trans('partner.deleted'),
        ], 200);
    }

    public function restore($id)
    {
        $this->partner->restore($id);

        return response()->json([
            'message' => trans('partner.restored'),
        ], 200);
    }

    public function forceDelete($id)
    {
        $this->partner->forceDelete($id);

        return response()->json([
            'message' => trans('partner.permanent_deleted'),
        ], 200);
    }

    public function status(Request $request)
    {
        $this->partner->status($request->id);

        return response()->json([
            'message' => trans('partner.status_updated'),
        ], 200);
    }

}
