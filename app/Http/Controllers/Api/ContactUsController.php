<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ContactUsRequest;
use App\Http\Resources\ContactUsCollection;
use App\Interfaces\ContactUsInterface;
use App\Models\ContactUs;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    protected $contactU;

    public function __construct(ContactUsInterface $contactU)
    {
        $this->contactUs=$contactU;
    }

    public function index()
    {
        if (request()->per_page) {
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;

            $query = ContactUs::query()
                ->where('status', 'Active')
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orderBy('id', 'asc')
                ->paginate($perPage);

            return new ContactUsCollection($query);
        } else {
            $query = ContactUs::query()->where('status', 'Active')->get();

            return new ContactUsCollection($query);
        }
    }

    public function deletedListIndex()
    {
        $contactU = $this->contactUs->onlyTrashed();
        return response()->json($contactU);
    }

    public function store(ContactUsRequest $request)
    {
        $contactU = $this->contactUs->create($request);

        return response()->json([
            'data' => $contactU,
            'message' => 'Contact-Us Created Successfully',
        ], 200);
    }

    public function show(ContactUs $contactU)
    {
        $contactU = $this->contactUs->findOrFail($contactU->id);
        return response()->json($contactU);
    }

    public function edit(ContactUs $contactU)
    {
        $contactU = $this->contactUs->findOrFail($contactU->id);
        return response()->json($contactU);
    }

    public function update(ContactUsRequest $request,ContactUs $contactU)
    {
        $contactU = $this->contactUs->update($contactU->id,$request);

        return response()->json([
            'data' => $contactU,
            'message' => 'Contact-Us Updated Successfully',
        ], 200);
    }

    public function destroy(ContactUs $contactU)
    {
        $this->contactUs->delete($contactU->id);
        return response()->json([
            'message' => trans('contactUs.deleted'),
        ], 200);
    }

    public function restore($id)
    {
        $this->contactUs->restore($id);
        return response()->json([
            'message' => trans('contactUs.restored'),
        ], 200);
    }

    public function forceDelete($id)
    {
        $this->contactUs->forceDelete($id);
        return response()->json([
            'message' => trans('contactUs.permanent_deleted'),
        ], 200);
    }

    public function status(Request $request)
    {
        $this->contactUs->status($request->id);
        return response()->json([
            'message' => trans('contactUs.status_updated'),
        ], 200);
    }
}
