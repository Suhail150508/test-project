<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OffensiveWordResource;
use App\Interfaces\OffensiveWordInterface;
use App\Models\OffensiveWord;
use Illuminate\Http\Request;

class OffensiveWordController extends Controller
{
    protected $offensiveWord;

    public function __construct(OffensiveWordInterface $offensiveWord)
    {
        $this->offensiveWord = $offensiveWord;
    }

    public function index()
    {
        if (request()->per_page) {
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;

            $query = OffensiveWord::query()
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orderBy('id', 'asc')
                ->paginate($perPage);

            return OffensiveWordResource::collection($query);
        } else {
            $query = $this->offensiveWord->get();

            return OffensiveWordResource::collection($query);
        }
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        $offensiveWord = $this->offensiveWord->create($request);
        return new OffensiveWordResource($offensiveWord);
    }

    public function show(OffensiveWord $offensiveWord)
    {

    }

    public function edit(OffensiveWord $offensiveWord)
    {

    }

    public function update(Request $request, OffensiveWord $offensiveWord)
    {
        $offensiveWord = $this->offensiveWord->update($offensiveWord->id, $request);
        $offensiveWord['update'] = "update";
        return new OffensiveWordResource($offensiveWord);
    }

    public function destroy(OffensiveWord $offensiveWord)
    {
        $offensiveWord = $this->offensiveWord->delete($offensiveWord->id);
        return response()->json($offensiveWord);
    }
}
