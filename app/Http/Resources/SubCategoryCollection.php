<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SubCategoryCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($subCategory) {
                return [
                    'id' => $subCategory->id,
                    'category' => $subCategory->category,
                    'category_id' => $subCategory->category_id,
                    'name' => $subCategory->name,
                    'status' => $subCategory->status,
                ];
            }),
            'categories' => Category::query()->get(),
        ];
    }
}
