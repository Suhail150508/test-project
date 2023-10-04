<?php

namespace App\Http\Controllers\Api;

use App\Models\Club;
use App\Models\ClubSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Interfaces\ClubSliderInterface;
use App\Http\Resources\ClubSliderResource;
use App\Http\Resources\ClubSliderCollection;
use App\Http\Requests\Admin\ClubSliderRequest;

class ClubSliderController extends Controller
{
    protected $club_slider;

    public function __construct(ClubSliderInterface $club_slider)
    {
        $this->club_slider = $club_slider;
    }

    public function index()
    {
        if (request()->per_page) {
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;

            $query = ClubSlider::query()
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orderBy('id', 'DESC')
                ->paginate($perPage);

            return new ClubSliderCollection($query);
        } else {
            $query = ClubSlider::query()->where('status', 'Active')->get();

            return new ClubSliderCollection($query);
        }
    }

    public function clubSliderList($id)
    {
        if (request()->per_page) {
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;
            $query = ClubSlider::query()
                ->where('club_id', $id)
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orderBy('id', 'DESC')
                ->paginate($perPage);

            return new ClubSliderCollection($query);
        } else {
            $query = ClubSlider::query()->where('club_id', $id)->paginate(12);
            return new ClubSliderCollection($query);
        }
    }

    public function clubSliderDeletedList($id) {
        if (request()->per_page) {
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;

            $query = ClubSlider::query()
                ->where('club_id', $id)
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orderBy('id', 'DESC')
                ->onlyTrashed()
                ->paginate($perPage);

            return new ClubSliderCollection($query);
        } else {
            $query = ClubSlider::query()->where('club_id', $id)->onlyTrashed()->get();
            return new ClubSliderCollection($query);
        }
    }

    public function store(ClubSliderRequest $request)
    {
        $data = $request;
        $parameters = [
            'image_info' => [
                [
                    'type' => 'club_slider',
                    'images' => $data->club_slider_image,
                    'directory' => 'club_slider',
                    'input_field' => 'club_slider_image',
                    'width' => '6000',
                    'height' => '2000',
                ],
            ],
        ];

        $club_slider = $this->club_slider->create($data, $parameters);

        return new ClubSliderResource($club_slider);
    }

    public function show(ClubSlider $clubSlider)
    {
        $query = $this->club_slider->findOrFail($clubSlider->id);
        return new ClubSliderResource($query);
    }

    public function update(Request $request, ClubSlider $clubSlider)
    {
        $data = $request;
        $update_parameters = [
            'image_info' => [
                [
                    'type' => 'club_slider',
                    'images' => $data->club_slider_image,
                    'directory' => 'club_slider',
                    'input_field' => 'club_slider_image',
                    'width' => '6000',
                    'height' => '2000'
                ],
            ],
        ];

        $club_slider = $this->club_slider->update($clubSlider->id, $data, $update_parameters);
        $request['update'] = 'update';

        return new ClubSliderResource($club_slider);
    }

    public function destroy(ClubSlider $clubSlider)
    {
        $this->club_slider->delete($clubSlider->id);

        return response()->json([
            'message' => 'Club slider successfully deleted',
        ], 200);
    }

    public function restore($id)
    {
        $this->club_slider->restore($id);

        return response()->json([
            'message' => "Club slider restored successfully",
        ], 200);
    }

    public function forceDelete($id) {
        $this->club_slider->forceDelete($id);

        return response()->json([
            'message' => "Club slider permanently deleted",
        ], 200);
    }
}
