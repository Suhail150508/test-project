<?php

namespace App\Http\Controllers\Api;

use App\Models\CccNews;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Interfaces\CccNewsInterface;
use App\Http\Resources\CccNewsResource;
use App\Http\Resources\CccNewsCollection;
use App\Http\Requests\Admin\CccNewsRequest;

class CccNewsController extends Controller
{
    protected $cccnews;

    public function __construct(CccNewsInterface $cccnews)
    {
        $this->cccnews = $cccnews;
    }

    public function index()
    {
        if (request()->per_page) {
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;

            $query = CccNews::query()
                ->with('ccc_news')
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orderBy('id', 'desc')
                ->paginate($perPage);

            return new CccNewsCollection($query);
        } else {
            $query = $this->cccnews->get();

            return new CccNewsCollection($query);
        }

    }

    public function store(Request $request)
    {
        $data = $request;
        $parameters = [
            'image_info' => [
                [
                    'type' => 'ccc_news',
                    'images' => $data->image,
                    'directory' => 'cccnews',
                    'input_field' => 'image',
                    'width' => '416',
                    'height' => '277',
                ],
            ],
        ];
        $cccNews = $this->cccnews->create($data, $parameters);
        $cccCategory = $cccNews->categories()->attach($request->categories);

        return response()->json([
            'data' => $cccNews,
            'cccCategory' => $cccCategory,
            'message' => 'CCC-News Created Successfully',
        ], 200);
    }

    public function show(CccNews $cccnews)
    {
        //
    }

    public function update(Request $request)
    {
        $data = $request;
        $data['published'] = $request->published == 'true' ? 1 : 0;
        $parameters = [
            'image_info' => [
                [
                    'type' => 'ccc_news',
                    'images' => $data->image,
                    'directory' => 'cccnews',
                    'input_field' => 'image',
                    'width' => '416',
                    'height' => '277',
                ],
            ],
        ];

        $cccNews = $this->cccnews->update($request->id,$data,$parameters);
        if ($request->categories){
            $cccCategory = $cccNews->categories()->attach($request->categories);
        }

        $request['update'] = 'update';

        return response()->json([
            'data' => $cccNews,
            'cccCategory' => $cccCategory,
            'message' => trans('cccNews.updated'),
        ], 200);
    }

    public function destroy($id)
    {
        $this->cccnews->delete($id);

        return response()->json([
            'message' => trans('cccNews.deleted'),
        ], 200);
    }
}
