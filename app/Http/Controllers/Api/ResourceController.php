<?php

namespace App\Http\Controllers\Api;

use App\Models\Seo;
use App\Models\Resource;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\ResourceInterface;
use App\Http\Resources\ResourceCccResource;
use App\Http\Requests\Admin\ResourceRequest;
use App\Http\Resources\ResourceCccCollection;

class ResourceController extends Controller
{
    protected $resource;

    public function __construct(ResourceInterface $resource)
    {
        $this->resource=$resource;
    }

    public function index()
    {
        if (request()->per_page) {
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;

            $query = Resource::query()
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orderBy('id', 'asc')
                ->paginate($perPage);

            return new ResourceCccCollection($query);
        } else {
            $resources = Resource::query()->where('status' ,'Active')->paginate(5);

            return new ResourceCccCollection($resources);
        }
    }

    public function deletedListIndex()
    {
        $resource = $this->resource->onlyTrashed();
        return response()->json($resource);
    }

    public function store(ResourceRequest $request)
    {
        $data = $request;
        $parameters = [
            'file_info' => [
                [
                    'type' => 'resource_attachment',
                    'files' => $data->resource_attachment,
                    'directory' => 'resource/attachment',
                    'input_field' => 'resource_attachment',
                ],
            ],
        ];

        // Generate the slug from the news title and Set the slug in the data array
        $slug = Str::slug($data['title']);
        $data['slug'] = $slug;

        $resource = $this->resource->create($data, $parameters);

        // Data insert in seo table
        $seo = new Seo();
        $seo->model_name = 'App\Models\Resource';
        $seo->model_id = $resource->id;
        $seo->site = 'ccc';
        $seo->page_url = '/resource-all/' . $resource->slug;
        $seo->title = $resource->title;
        $seo->keywords = 'ccc resource';
        $seo->description = Str::limit(strip_tags($resource->description), 100);
        $seo->save();

        return new ResourceCccResource($resource);
    }

    // public function show(Resource $resource)
    // {
    //     $resource = $this->resource->findOrFail($resource->id);
    //     $resource['resource_attachment'] = $resource->resourceAttachment ? $resource->resourceAttachment->source : null;
    //     return response()->json($resource);
    // }

    public function show($slug)
    {
        $resource = $this->resource->where('slug', $slug)->firstOrFail();
        $resource['resource_attachment'] = $resource->resourceAttachment ? $resource->resourceAttachment->source : null;
        return response()->json($resource);
    }

    public function edit(Resource $resource)
    {
        $resource = $this->resource->findOrFail($resource->id);
        return response()->json($resource);
    }

    public function update(ResourceRequest $request, Resource $resource)
    {
        $data = $request;
        $parameters = [
            'file_info' => [
                [
                    'type' => 'resource_attachment',
                    'files' => $data->resource_attachment,
                    'directory' => 'resource/attachment',
                    'input_field' => 'resource_attachment',
                ],
            ],
        ];

        // Generate the slug from the news title and Set the slug in the data array
        $slug = Str::slug($data['title']);
        $data['slug'] = $slug;

        $resource = $this->resource->update($resource->id,$data, $parameters);

        // Update or create the SEO entry
        Seo::updateOrCreate(
            ['model_name' => 'App\Models\Resource', 'model_id' => $resource->id],
            [
                'site' => 'ccc',
                'page_url' => '/resource-all/' . $resource->slug,
                'title' => $resource->title,
                'keywords' => 'ccc resource',
                'description' => Str::limit(strip_tags($resource->description), 100),
            ]
        );

        $request['update'] = 'update';
        return new ResourceCccResource($resource);
    }

    public function destroy(Resource $resource)
    {
        $this->resource->delete($resource->id);
        return response()->json([
            'message' => trans('resource.deleted'),
        ], 200);
    }

    public function restore($id)
    {
        $this->resource->restore($id);
        return response()->json([
            'message' => trans('resource.restored'),
        ], 200);
    }

    public function forceDelete($id)
    {
        $this->resource->forceDelete($id);
        return response()->json([
            'message' => trans('resource.permanent_deleted'),
        ], 200);
    }

    public function status(Request $request)
    {
        $this->resource->status($request->id);
        return response()->json([
            'message' => trans('resource.status_updated'),
        ], 200);
    }
}
