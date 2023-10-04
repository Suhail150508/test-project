<?php

namespace App\Http\Controllers\Api;

use App\Models\AboutCcc;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\AboutCccInterface;
use App\Http\Resources\AboutCccResource;
use App\Http\Resources\AboutCccCollection;
use App\Http\Requests\Admin\AboutCCCRequest;

class AboutCCCController extends Controller
{
    protected $aboutCcc;

    public function __construct(AboutCccInterface $aboutCcc)
    {
        $this->aboutCcc = $aboutCcc;
    }

    public function index()
    {
        if (request()->per_page){
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;

            $query = AboutCcc::query()
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orderBy('id', 'desc')
                ->paginate($perPage);

            return new AboutCccCollection($query);
        } else{
            $aboutCcc = AboutCcc::query()->where('status','Active')->first();
            return response()->json($aboutCcc);
        }


    }

    public function store(AboutCCCRequest $request)
    {
        $aboutCcc = $this->aboutCcc->create($request);

        return new AboutCccResource($aboutCcc);
    }

    public function show(AboutCcc $aboutCcc)
    {
        $aboutCcc = $this->aboutCcc->findOrFail($aboutCcc->id);

        return response()->json($aboutCcc);
    }

    public function edit($id)
    {
        $aboutCcc = $this->aboutCcc->findOrFail($id);

        return response()->json($aboutCcc);
    }

    public function update(AboutCCCRequest $request)
    {
        $aboutCcc = $this->aboutCcc->update($request->id,$request);

        return response()->json([
            'data' => $aboutCcc,
            'success'=> trans('aboutCcc.updated')
        ],200);
    }
}
