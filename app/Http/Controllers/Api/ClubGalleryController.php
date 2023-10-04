<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ClubGalleryRequest;
use App\Http\Resources\ClubGalleryCollection;
use App\Interfaces\ClubGalleryInterface;
use App\Models\Club;
use App\Models\CLubGallery;
use Illuminate\Http\Request;

class ClubGalleryController extends Controller
{
    protected $clubGalley;

    public function __construct(ClubGalleryInterface $clubGalley)
    {
        $this->clubGalley=$clubGalley;
    }

    public function clubGalleryIndex($shortName)
    {
        if (request()->per_page) {
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;
            $club = Club::where('short_name',$shortName)->first();
            $query = ClubGallery::query()
                ->where('club_id', $club->id)
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orderBy('id', 'asc')
                ->paginate($perPage);

            return new ClubGalleryCollection($query);
        }else{
            $club = Club::where('short_name',$shortName)->first();
            $clubGalley = ClubGallery::query()->where('club_id', $club->id)->paginate(12);
            return new ClubGalleryCollection($clubGalley);
        }
    }

    public function deletedListIndex($club_id)
    {
        if (request()->per_page) {
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;

            $query = ClubGallery::query()
                ->where('club_id', $club_id)
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orderBy('id', 'asc')
                ->onlyTrashed()
                ->paginate($perPage);

            return new ClubGalleryCollection($query);
        }else{
            $clubGalley = ClubGallery::query()->where('club_id', $club_id)->onlyTrashed()->get();
            return new ClubGalleryCollection($clubGalley);
        }
    }

    public function clubGalleyEventList() {
        $clubGalleyEvents = ClubGallery::query()->get();
        return new ClubGalleryCollection($clubGalleyEvents);
    }

    public function store(ClubGalleryRequest $request)
    {
        $data = $request;

        $parameters = [
            'image_info' => [
                [
                    'type' => 'club_gallery_image',
                    'images' => $data->club_gallery_image,
                    'directory' => 'club_gallery_image',
                    'input_field' => 'club_gallery_image',
                    'width' => '140',
                    'height' => '120',
                ],
            ],
        ];

        $clubGalley = $this->clubGalley->create($data, $parameters);

        return response()->json([
            'data' => $clubGalley,
            'message' => "Club Gallery Created Successfully",
        ], 200);
    }

    public function typeWiseMedia($clubId,$type)
    {
        $clubGalley = ClubGallery::query()->with('clubGalleyPhoto')->where('club_id',$clubId)->where('type',$type)->get();

        return response()->json($clubGalley);
    }

    public function show($id)
    {
        $clubGalley = $this->clubGalley->with(['clubGalleyPhoto'])->findOrFail($id);

        return response()->json($clubGalley);
    }

    public function edit($id)
    {
        $clubGalley = $this->clubGalley->with(['clubGalleyMainLogo','clubGalleyHeaderLogo','linkDetails'])->findOrFail($id);

        return response()->json($clubGalley);
    }

    public function update(ClubGalleryRequest $request)
    {
        $data = $request;

        $parameters = [
            'image_info' => [
                [
                    'type' => 'club_gallery_image',
                    'images' => $data->club_gallery_image,
                    'directory' => 'club_gallery_image',
                    'input_field' => 'club_gallery_image',
                    'width' => '140',
                    'height' => '120',
                ],
            ],
        ];

        $clubGalley = $this->clubGalley->update($request->id, $data, $parameters);

        return response()->json([
            'data' => $clubGalley,
            'message' => "Club Gallery Updated Successfully",
        ], 200);
    }

    public function destroy($id)
    {
        $this->clubGalley->delete($id);

        return response()->json([
            'message' => "Club-Gallery deleted Successfully",
        ], 200);
    }

    public function restore($id)
    {
        $this->clubGalley->restore($id);

        return response()->json([
            'message' => "Club-Gallery Restored Successfully",
        ], 200);
    }

    public function forceDelete($id)
    {
        $this->clubGalley->forceDelete($id);

        return response()->json([
            'message' => "Club-Gallery Permanently Deleted",
        ], 200);
    }

    public function status(Request $request)
    {
        $this->clubGalley->status($request->id);

        return response()->json([
            'message' => "Club-Gallery Status Updated Successfully",
        ], 200);
    }
}
