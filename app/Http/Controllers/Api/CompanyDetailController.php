<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CompanyDetailRequest;
use App\Http\Resources\CompanyDetailResource;
use App\Interfaces\CompanyDetailInterface;
use App\Models\Address;
use App\Models\CompanyDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CompanyDetailController extends Controller
{
    protected $companyDetail;

    public function __construct(CompanyDetailInterface $companyDetail)
    {
        $this->companyDetail = $companyDetail;
    }

    public function index()
    {
        $company_detail = $this->companyDetail->with(['user','address'])->get();

        return response()->json($company_detail);
    }

    public function deletedListIndex()
    {
        $company_detail = $this->companyDetail->onlyTrashed();

        return response()->json($company_detail);
    }

    public function store(CompanyDetailRequest $request)
    {
        $data = $request;
        $userInfos = $request->userInfos;
        $userInfos['password'] = Hash::make($request->userInfos['password']);
        $add = $request->add;

        $parameters = [
            'create_single' => [
                [
                    'relation' => 'user',
                    'data' => $userInfos,
                ],
                [
                    'relation' => 'address',
                    'data' => $add,
                ],
            ],
        ];

        $companyDetail = $this->companyDetail->create($data,$parameters);
        return new CompanyDetailResource($companyDetail);
    }

    public function show($id)
    {
        $companyDetail = $this->companyDetail->with(['user','address'])->findOrFail($id);

        return response()->json($companyDetail);
    }

    public function edit($id)
    {
        $companyDetail = $this->companyDetail->with(['user','address'])->findOrFail($id);

        return response()->json($companyDetail);
    }

    public function update(CompanyDetailRequest $request, $id)
    {
        $data = $request;
        $userInfos = $request->userInfos;
        $userInfos['password'] = Hash::make($request->userInfos['password']);
        $add = $request->add;

        $parameters = [
            'update_single' => [
                [
                    'relation' => 'user',
                    'data' => $userInfos,
                ],
                [
                    'relation' => 'address',
                    'data' => $add,
                ],
            ],
        ];

        $companyDetail = $this->companyDetail->update($id, $data, $parameters);
        $request['update'] = 'update';
        return new CompanyDetailResource($companyDetail);
    }

    public function destroy(CompanyDetail $company_detail)
    {
        DB::beginTransaction();
        try {
            $this->companyDetail->delete($company_detail->id);
            $company_detail->user()->delete();
            $company_detail->address()->delete();
            DB::commit();
            return response()->json([
                'message' => trans('companyDetail.deleted'),
            ], 200);
        } catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }

    public function restore($id)
    {
        DB::beginTransaction();
            $this->companyDetail->restore($id);
            $user = User::onlyTrashed()->where('company_detail_id', $id)->first();
            $address = Address::onlyTrashed()->where('company_detail_id', $id)->first();
            if ($user != null && $address != null) {
                $user->restore();
                $address->restore();
            }
        DB::commit();
            return response()->json([
                'message' => trans('companyDetail.restored'),
            ], 200);
        DB::rollBack();
    }

    public function forceDelete($id)
    {
        $this->companyDetail->forceDelete($id);

        return response()->json([
            'message' => trans('companyDetail.permanent_deleted'),
        ], 200);
    }

}
