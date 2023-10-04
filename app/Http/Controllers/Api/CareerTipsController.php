<?php

namespace App\Http\Controllers\Api;

use App\Models\Seo;
use App\Models\CareerTips;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\CareerTipsInterface;
use App\Http\Resources\CareerTipsResource;
use App\Http\Resources\CareerTipsCollection;

class CareerTipsController extends Controller
{
    protected $careerTips;

    public function __construct(CareerTipsInterface $careerTips)
    {
        $this->careerTips = $careerTips;
    }

    public function index()
    {
        if (request()->per_page) {
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;

            $query = CareerTips::query()
                ->with('careerTips')
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orderBy('id', 'desc')
                ->paginate($perPage);

            return new CareerTipsCollection($query);
        } else {
            $query = CareerTips::query()->with('careerTips')->where('published',1)->paginate(10);

            return new CareerTipsCollection($query);
        }
    }

    public function store(Request $request)
    {
        $data = $request;
        $data['published'] = $request->published == "true" ? 1 : 0;
        $parameters = [
            'image_info' => [
                [
                    'type' => 'career_tips',
                    'images' => $data->image,
                    'directory' => 'career_tips',
                    'input_field' => 'image',
                    'width' => '416',
                    'height' => '277',
                ],
            ],
        ];

        // Generate the slug from the news title and Set the slug in the data array
        $slug = Str::slug($data['title']);
        $data['slug'] = $slug;

        $careerTips = $this->careerTips->create($data, $parameters);

        // Data insert in seo table
        $seo = new Seo();
        $seo->model_name = 'App\Models\CareerTips';
        $seo->model_id = $careerTips->id;
        $seo->site = 'ccc';
        $seo->page_url = '/single-career-tips/' . $careerTips->slug;
        $seo->title = $careerTips->title;
        $seo->keywords = 'Career Tips, Tricks';
        $seo->description = Str::limit(strip_tags($careerTips->body), 100);
        $seo->save();

        return new CareerTipsResource($careerTips);
    }

    // public function show(CareerTips $career_tip)
    // {
    //     $careerTips = $this->careerTips->findOrFail($career_tip->id);
    //     $careerTips['image'] =  $careerTips->careerTips ? $careerTips->careerTips->source : "";
    //     return response()->json($careerTips);

    // }

    public function show($slug)
    {
        $careerTips = $this->careerTips->where('slug', $slug)->firstOrFail();
        $careerTips['image'] =  $careerTips->careerTips ? $careerTips->careerTips->source : "";
        return response()->json($careerTips);
    }

    public function edit(CareerTips $careerTips)
    {
        //
    }

    public function update(Request $request)
    {
        $data = $request;
        $data['published'] = $request->published == "true" ? 1 : 0;
        $parameters = [
            'image_info' => [
                [
                    'type' => 'career_tips',
                    'images' => $data->image,
                    'directory' => 'career_tips',
                    'input_field' => 'image',
                    'width' => '416',
                    'height' => '277',
                ],
            ],
        ];

        // Generate the slug from the news title and Set the slug in the data array
        $slug = Str::slug($data['title']);
        $data['slug'] = $slug;

        $careerTips = $this->careerTips->update($request->id, $data, $parameters);

        // Update or create the SEO entry
        Seo::updateOrCreate(
            ['model_name' => 'App\Models\CareerTips', 'model_id' => $careerTips->id],
            [
                'site' => 'ccc',
                'page_url' => '/single-career-tips/' . $careerTips->slug,
                'title' => $careerTips->title,
                'keywords' => 'Career Tips, Tricks',
                'description' => Str::limit(strip_tags($careerTips->body), 100),
            ]
        );

        return response()->json([
            'data' => $careerTips,
            'message' => 'Career Tips Updated Successfully',
        ], 200);
    }

    public function destroy($id)
    {
        $this->careerTips->delete($id);

        return response()->json([
            'message' => 'Career Tips deleted Successfully',
        ], 200);
    }
}
