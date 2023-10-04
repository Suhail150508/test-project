<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CccFaqRequest;
use App\Interfaces\CccFaqInterface;
use App\Models\CccFaq;
use Illuminate\Http\Request;
use App\Http\Resources\CCCFaqCollection;

class CCCFaqController extends Controller
{
    protected $ccc_faq;

    public function __construct(CccFaqInterface $ccc_faq)
    {
        $this->ccc_faq = $ccc_faq;
    }

    public function index()
    {
        if (request()->per_page) {
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;

            $query = CccFaq::query()
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orderBy('id', 'asc')
                ->paginate($perPage);

            return new CCCFaqCollection($query);
        }else{
            $ccc_faq = $this->ccc_faq->get();
            return response()->json($ccc_faq);
        }
    }

    public function deletedListIndex()
    {
        $ccc_faq = $this->ccc_faq->onlyTrashed();

        return response()->json($ccc_faq);
    }

    public function create()
    {
        //
    }

    public function store(CccFaqRequest $request)
    {
        $ccc_faq = $this->ccc_faq->create($request);

        return response()->json([
            'data' => $ccc_faq,
            'success' => trans('cccFaq.created'),
        ], 200);
    }

    public function show(CccFaq $cccFaq)
    {
        $ccc_faq = $this->ccc_faq->findOrFail($cccFaq->id);
        return response()->json($ccc_faq);
    }


    public function edit($id)
    {
        $ccc_faq = $this->ccc_faq->findOrFail($id);
        return response()->json($ccc_faq);
    }


    public function update(CccFaqRequest $request, CccFaq $cccFaq)
    {
        $ccc_faq = $this->ccc_faq->update($cccFaq->id,$request);

        return response()->json([
            'data' => $ccc_faq,
            'success' => trans('cccFaq.updated'),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CccFaq  $cccFaq
     * @return \Illuminate\Http\Response
     */
    public function destroy(CccFaq $cccFaq)
    {
        $cccFaq->delete();
        return response()->json(['success']);
    }
}
