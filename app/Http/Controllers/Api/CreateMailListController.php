<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateMailListRequest;
use App\Http\Resources\CreateMailListCollection;
use App\Interfaces\CreateMailListInterface;
use Illuminate\Support\Facades\DB;
use App\Models\CreateMailList;
use Illuminate\Http\Request;

class CreateMailListController extends Controller
{
    protected $createMailList;

    public function __construct(CreateMailListInterface $createMailList)
    {
        $this->createMailList=$createMailList;
    }

    public function index()
    {
        if (request()->per_page) {
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;

            $query = CreateMailList::query()
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orderBy('id', 'asc')
                ->paginate($perPage);

            return new CreateMailListCollection($query);
        } else {
            $query = $this->createMailList->get();

            return new CreateMailListCollection($query);
        }
    }

    public function deletedListIndex()
    {
        $createMailList = $this->createMailList->onlyTrashed();

        return response()->json($createMailList);
    }

    public function store(CreateMailListRequest $request)
    {
        try {
            DB::beginTransaction();
            $request['existing_recipients'] = json_encode($request->existing_recipients);

            $parameters = [
                'file_info' => [
                    [
                        'type' => 'newsletterMailListFile',
                        'files' => $request->others_mail_file,
                        'directory' => 'newsletterMailList',
                        'input_field' => 'others_mail_file',
                    ],
                ],
            ];

            $createMailList = $this->createMailList->create($request, $parameters);
            DB::commit();

            return response()->json($createMailList);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }

    public function show(CreateMailList $createMailList)
    {
        $createMailList = $this->createMailList->findOrFail($createMailList->id);

        return response()->json($createMailList);
    }

    public function edit(CreateMailList $createMailList)
    {
        $createMailList = $this->createMailList->findOrFail($createMailList->id);
        return response()->json($createMailList);
    }

    public function update(CreateMailListRequest $request, CreateMailList $createMailList)
    {
        $createMailList = $this->createMailList->update($createMailList->id,$request);

        return response()->json($createMailList);
    }

    public function destroy(CreateMailList $createMailList)
    {
        $this->createMailList->delete($createMailList->id);
        return response()->json([
            'message' => trans('createMailList.deleted'),
        ], 200);
    }

    public function restore($id)
    {
        $this->createMailList->restore($id);
        return response()->json([
            'message' => trans('createMailList.restored'),
        ], 200);
    }

    public function forceDelete($id)
    {
        $this->createMailList->forceDelete($id);
        return response()->json([
            'message' => trans('createMailList.permanent_deleted'),
        ], 200);
    }

    public function status(Request $request)
    {
        $this->createMailList->status($request->id);
        return response()->json([
            'message' => trans('createMailList.status_updated'),
        ], 200);
    }
}
