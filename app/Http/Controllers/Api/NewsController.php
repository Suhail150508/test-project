<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NewsRequest;
use App\Http\Resources\NewsCollection;
use App\Interfaces\NewsInterface;
use App\Models\News;
use App\Models\Seo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsController extends Controller
{

    protected $news;

    public function __construct(NewsInterface $news)
    {
        $this->news=$news;
    }

    public function index()
    {


        if(request()->per_page && request()->place == 'alumni') {
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;

            $query = News::query()
                ->where('place', request()->place)
                ->where('status', 'Active')
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orderBy('id', 'asc')
                ->paginate($perPage);

            return new NewsCollection($query);
        } elseif (request()->per_page) {
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;

            $query = News::query()
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orderBy('id', 'asc')
                ->paginate($perPage);

            return new NewsCollection($query);
        }
        elseif(request()->type && !request()->semester_and_year){

            $news = News::query()->where('place', request()->place)->where('types',request()->type)->where('status','Active')->orderBy('id', 'desc')->paginate(10);
            return new NewsCollection($news);
        }elseif(request()->type && request()->semester_and_year){
            $news = News::query()->where('place', request()->place)->where('types',request()->type)->where('semester_and_year',request()->semester_and_year)->where('status','Active')->orderBy('id', 'desc')->paginate(10);
            return new NewsCollection($news);
        }
        else{
            // dd('ami jekhane vabsi');
            $news = News::query()->where('place', request()->place)->where('status','Active')->orderBy('id', 'desc')->paginate(10);

            return new NewsCollection($news);
        }
    }

    public function deletedListIndex()
    {
        $news = $this->news->onlyTrashed();

        return response()->json($news);
    }


    public function store(NewsRequest $request)
    {
        $data = $request;
        $parameters = [
            'image_info' => [
                [
                    'type' => 'news',
                    'images' => $data->images,
                    'directory' => 'news',
                    'input_field' => 'image',
                    'width' => '416',
                    'height' => '277',
                ],
            ],
        ];

        // Generate the slug from the news title and Set the slug in the data array
        $slug = Str::slug($data['title']);
        $data['slug'] = $slug;

        $news = $this->news->create($data, $parameters);

        // Data insert in seo table
        if ($data->place == 'ccc_home') {
            $seo = new Seo();
            $seo->model_name = 'App\Models\News';
            $seo->model_id = $news->id;
            $seo->site = 'ccc';
            $seo->page_url = '/special-news/'. $news->slug;
            $seo->title = $news->title;
            $seo->keywords = 'ccc, news';
            $seo->description = Str::limit(strip_tags($news->description), 100);
            $seo->save();
        } elseif ($data->place == 'alumni') {
            $seo = new Seo();
            $seo->model_name = 'App\Models\News';
            $seo->model_id = $news->id;
            $seo->site = 'alumni';
            $seo->page_url = '/news/' . $news->slug;
            $seo->title = $news->title;
            $seo->keywords = 'alumni, news';
            $seo->description = Str::limit(strip_tags($news->description), 100);
            $seo->save();
        }

        return response()->json([
            'data' => $news,
            'message' => 'News Created Successfully',
            ], 200);
    }

    // public function show(News $news)
    // {
    //     $news = $this->news->findOrFail($news->id);
    //     $news['images'] = $news->files ? $news->files : "";
    //     return response()->json($news);
    // }

    public function show($slug)
    {
        $news = $this->news->where('slug', $slug)->firstOrFail();
        $news['images'] = $news->files ? $news->files : "";
        return response()->json($news);
    }

    public function edit($id)
    {
        $news = $this->news->findOrFail($id);

        return response()->json($news);
    }

    public function update(NewsRequest $request, News $news)
    {
        $data = $request;
        $parameters = [
            'image_info' => [
                [
                    'type' => 'news',
                    'images' => $data->images,
                    'directory' => 'news',
                    'input_field' => 'image',
                    'width' => '416',
                    'height' => '277',
                ],
            ],
        ];

        // Generate the slug from the news title and Set the slug in the data array
        $slug = Str::slug($data['title']);
        $data['slug'] = $slug;

        $news = $this->news->update($news->id,$data,$parameters);

        $request['update'] = 'update';

        // Update or create the SEO entry
        if ($data->place == 'ccc_home') {
            Seo::updateOrCreate(
                ['model_name' => 'App\Models\News', 'model_id' => $news->id],
                [
                    'site' => 'ccc',
                    'page_url' => '/special-news/' . $news->slug,
                    'title' => $news->title,
                    'keywords' => 'ccc, news',
                    'description' => Str::limit(strip_tags($news->description), 100),
                ]
            );
        } elseif ($data->place == 'alumni') {
            Seo::updateOrCreate(
                ['model_name' => 'App\Models\News', 'model_id' => $news->id],
                [
                    'site' => 'alumni',
                    'page_url' => '/news/' . $news->slug,
                    'title' => $news->title,
                    'keywords' => 'alumni, news',
                    'description' => Str::limit(strip_tags($news->description), 100),
                ]
            );
        }

        return response()->json([
            'data' => $news,
            'message' => trans('news.updated'),
        ], 200);
    }

    public function destroy(News $news)
    {
        $this->news->delete($news->id);

        return response()->json([
            'message' => trans('news.deleted'),
        ], 200);
    }

    public function restore($id)
    {
        $this->news->restore($id);

        return response()->json([
            'message' => trans('news.restored'),
        ], 200);
    }

    public function forceDelete($id)
    {
        $this->news->forceDelete($id);

        return response()->json([
            'message' => trans('news.permanent_deleted'),
        ], 200);
    }

    public function status(Request $request)
    {
        $this->news->status($request->id);

        return response()->json([
            'message' => trans('news.status_updated'),
        ], 200);
    }
}
