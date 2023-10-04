<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    public function index()
    {
        if (!empty(request()->all())) {
            // If more than 0
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;

            $query = Category::query()
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orderBy('id', 'desc')
                ->paginate($perPage);

            return new CategoryCollection($query);
        } else {
            // If 0
            $query = Category::query()->get();

            return new CategoryCollection($query);
        }
    }

    public function store(CategoryRequest $request)
    {
        $data = $request->validated();
        $category = Category::create($data);

        return new CategoryResource($category);
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $data = $request->validated();
        $category->update($data);

        return new CategoryResource($category);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return response()->noContent();
    }
}
