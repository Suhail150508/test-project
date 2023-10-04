<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SubCategoryRequest;
use App\Http\Resources\SubCategoryCollection;
use App\Http\Resources\SubCategoryResource;
use App\Interfaces\SubCategoryInterface;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    protected $subCategory;

    public function __construct(SubCategoryInterface $subCategory)
    {
        $this->subCategory = $subCategory;
    }

    public function index()
    {
        if (!empty(request()->all())) {
            // If more than 0
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;

            $query = SubCategory::query()
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orWhereHas('category', function ($query) {
                    $keyword = request()->keyword;
                    $fieldName = request()->field_name;
                    $query->where($fieldName, 'LIKE', "%$keyword%");
                })
                ->orderBy('id',
                    'asc'
                )
                ->paginate($perPage);

            return new SubCategoryCollection($query);
        } else {
            // If 0
            $query = SubCategory::query()->get();

            return new SubCategoryCollection($query);
        }
    }

    public function store(SubCategoryRequest $request)
    {
        $subCategory = $this->subCategory->create($request);
        return new SubCategoryResource($subCategory);
    }

    public function update(Request $request, SubCategory $subCategory)
    {
        $subCategory = $this->subCategory->update($subCategory->id, $request);
        $request['update'] = "update";
        return new SubCategoryResource($subCategory);
    }

    public function destroy(SubCategory $subCategory)
    {
        $subCategory = $this->subCategory->delete($subCategory->id);
        return response()->json($subCategory);
    }
}
