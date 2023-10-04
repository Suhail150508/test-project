<?php

namespace App\Http\Controllers\Api;

use App\Models\Seo;
use App\Models\CccUpdates;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\CccUpdatesInterface;
use App\Http\Resources\CccUpdatesResource;
use App\Http\Resources\CccUpdatesCollection;
use App\Http\Requests\Admin\CccUpdatesRequest;

class CccUpdatesController extends Controller
{
    protected $ccc_updates;

    public function __construct(CccUpdatesInterface $ccc_updates)
    {
        $this->ccc_updates = $ccc_updates;
    }

    public function index()
    {
        if (request()->per_page){
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;

            $query = CccUpdates::query()
                ->with('ccc_updates')
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orderBy('id', 'asc')
                ->paginate($perPage);

            return new CccUpdatesCollection($query);
        } else{
            if (request()->type && !request()->semester_and_year){
                $ccc_updates = CccUpdates::query()->with('ccc_updates')->where('published',1)->where('types',request()->type)->paginate(6);
            } elseif (request()->type && request()->semester_and_year){
                $ccc_updates = CccUpdates::query()->with('ccc_updates')->where('published', 1)->where('types', request()->type)->where('semester_and_year', request()->semester_and_year)->paginate(6);
            } else{
                $ccc_updates = CccUpdates::query()->with('ccc_updates')->where('published',1)->paginate(6);
            }

            return new CccUpdatesCollection($ccc_updates);
        }

    }

    public function deletedListIndex()
    {
        $ccc_updates = $this->ccc_updates->onlyTrashed();
        return response()->json($ccc_updates);
    }

    public function store(CccUpdatesRequest $request)
    {
        $data = $request;
        $parameters = [
            'image_info' => [
                [
                    'type' => 'ccc_updates',
                    'images' => $data->image,
                    'directory' => 'cccUpdates',
                    'input_field' => 'image',
                    'width' => '416',
                    'height' => '277',
                ],
            ],
        ];

        // Generate the slug from the news title and Set the slug in the data array
        $slug = Str::slug($data['title']);
        $data['slug'] = $slug;

        $cccUpdates = $this->ccc_updates->create($data, $parameters);
        $cccCategory = $cccUpdates->categories()->attach($request->categories);

        // Data insert in seo table
        $seo = new Seo();
        $seo->model_name = 'App\Models\CccUpdates';
        $seo->model_id = $cccUpdates->id;
        $seo->site = 'ccc';
        $seo->page_url = '/ccc-updates/' . $cccUpdates->slug;
        $seo->title = $cccUpdates->title;
        $seo->keywords = 'ccc-updates';
        $seo->description = Str::limit(strip_tags($cccUpdates->description), 100);
        $seo->save();

        return new CccUpdatesResource($cccUpdates, $cccCategory);
    }

    // public function show($id)
    // {
    //     $ccc_updates = $this->ccc_updates->findOrFail($id);
    //     $ccc_updates['image'] =  $ccc_updates->ccc_updates ? $ccc_updates->ccc_updates->source : '';
    //     return response()->json($ccc_updates);
    // }

    public function show($slug)
    {
        $ccc_updates = $this->ccc_updates->where('slug', $slug)->firstOrFail();
        $ccc_updates['image'] =  $ccc_updates->ccc_updates ? $ccc_updates->ccc_updates->source : '';
        return response()->json($ccc_updates);
    }

    public function edit(CccUpdates $ccc_updates)
    {
        $ccc_updates = $this->ccc_updates->findOrFail($ccc_updates->id);
        return response()->json($ccc_updates);
    }

    public function update(CccUpdatesRequest $request)
    {
        $data = $request;
        $parameters = [
            'image_info' => [
                [
                    'type' => 'ccc_updates',
                    'images' => $data->image,
                    'directory' => 'cccUpdates',
                    'input_field' => 'image',
                    'width' => '416',
                    'height' => '277',
                ],
            ],
        ];

        // Generate the slug from the news title and Set the slug in the data array
        $slug = Str::slug($data['title']);
        $data['slug'] = $slug;

        $ccc_updates = $this->ccc_updates->update($request->id,$data, $parameters);
        $cccCategory = $ccc_updates->categories()->attach($request->categories);
        $request['update'] = 'update';

        // Update or create the SEO entry
        Seo::updateOrCreate(
            ['model_name' => 'App\Models\CccUpdates', 'model_id' => $ccc_updates->id],
            [
                'site' => 'ccc',
                'page_url' => '/ccc-updates/' . $ccc_updates->slug,
                'title' => $ccc_updates->title,
                'keywords' => 'ccc-updates',
                'description' => Str::limit(strip_tags($ccc_updates->description), 100),
            ]
        );

        return new CccUpdatesResource($ccc_updates, $cccCategory);
    }

    public function destroy(CccUpdates $ccc_update)
    {
        $this->ccc_updates->delete($ccc_update->id);
        return response()->json([
            'message' => trans('ccc_updates.deleted'),
        ], 200);
    }

    public function restore($id)
    {
        $this->ccc_updates->restore($id);
        return response()->json([
            'message' => trans('ccc_updates.restored'),
        ], 200);
    }

    public function forceDelete($id)
    {
        $this->ccc_updates->forceDelete($id);
        return response()->json([
            'message' => trans('ccc_updates.permanent_deleted'),
        ], 200);
    }

    public function status(Request $request)
    {
        $this->ccc_updates->status($request->id);
        return response()->json([
            'message' => trans('ccc_updates.status_updated'),
        ], 200);
    }
}
