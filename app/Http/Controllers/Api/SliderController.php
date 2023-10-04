<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SliderRequest;
use App\Http\Resources\SliderCollection;
use App\Interfaces\SliderInterface;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    protected $slider;

    public function __construct(SliderInterface $slider)
    {
        $this->slider=$slider;
    }

    public function index()
    {
        if (request()->per_page) {
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;

            $query = Slider::query()
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orderBy('id', 'asc')
                ->paginate($perPage);

            return new SliderCollection($query);
        } else {
            $query = Slider::query()->where('place', request()->place)->where('slider_status','Active')->get();

            return new SliderCollection($query);
        }
    }

    public function deletedListIndex()
    {
        $slider = $this->slider->onlyTrashed();
        return response()->json($slider);
    }

    public function store(SliderRequest $request)
    {
        $data = $request;
        $parameters = [
            'image_info' => [
                [
                    'type' => 'slider',
                    'images' => $data->image,
                    'directory' => 'slider',
                    'input_field' => 'image',
                    'width' => '6000',
                    'height' => '2000'
                ],
            ],
        ];
        $slider = $this->slider->create($data, $parameters);

        return response()->json([
            'data' => $slider,
            'message' => 'Slider Created Successfully',
        ], 200);
    }

    public function show(Slider $slider)
    {
        $slider = $this->slider->findOrFail($slider->id);
        return response()->json($slider);
    }

    public function edit(Slider $slider)
    {
        $slider = $this->slider->findOrFail($slider->id);
        return response()->json($slider);
    }

    public function update(SliderRequest $request, Slider $slider)
    {
        $data = $request;
        $update_parameters = [
            'image_info' => [
                [
                    'type' => 'slider',
                    'images' => $data->image,
                    'directory' => 'slider',
                    'input_field' => 'image',
                    'width' => '6000',
                    'height' => '2000'
                ],
            ],
        ];

        $slider = $this->slider->update($slider->id, $data, $update_parameters);

        return response()->json([
            'data' => $slider,
            'message' => 'Slider Updated Successfully',
        ], 200);
    }

    public function destroy(Slider $slider)
    {
        $this->slider->delete($slider->id);
        return response()->json([
            'message' => trans('slider.deleted'),
        ], 200);
    }

    public function restore($id)
    {
        $this->slider->restore($id);
        return response()->json([
            'message' => trans('slider.restored'),
        ], 200);
    }

    public function forceDelete($id)
    {
        $this->slider->forceDelete($id);
        return response()->json([
            'message' => trans('slider.permanent_deleted'),
        ], 200);
    }

    public function status(Request $request)
    {
        $this->slider->status($request->id);
        return response()->json([
            'message' => trans('slider.status_updated'),
        ], 200);
    }
}
