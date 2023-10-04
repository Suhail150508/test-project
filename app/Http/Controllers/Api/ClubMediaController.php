<?php

namespace App\Http\Controllers\Api;

use App\Models\Seo;
use App\Models\Club;
use App\Models\ClubMedia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\ClubMediaInterface;
use App\Http\Resources\ClubMediaCollection;
use App\Http\Requests\Admin\ClubMediaRequest;

class ClubMediaController extends Controller
{
    protected $clubMedia;

    public function __construct(ClubMediaInterface $clubMedia)
    {
        $this->clubMedia=$clubMedia;
    }

    public function clubMediaIndex($club_id)
    {
        if (request()->per_page) {
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;

            $query = ClubMedia::query()
                ->where('club_id', $club_id)
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orderBy('id', 'asc')
                ->paginate($perPage);

            return new ClubMediaCollection($query);
        }else{
            $clubMedia = ClubMedia::query()->where('club_id', $club_id)->get();
            return new ClubMediaCollection($clubMedia);
        }
    }

    public function deletedListIndex($club_id)
    {
        if (request()->per_page) {
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;

            $query = ClubMedia::query()
                ->where('club_id', $club_id)
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orderBy('id', 'asc')
                ->onlyTrashed()
                ->paginate($perPage);

            return new ClubMediaCollection($query);
        }else{
            $clubMedia = ClubMedia::query()->where('club_id', $club_id)->onlyTrashed()->get();
            return new ClubMediaCollection($clubMedia);
        }
    }

    public function clubMediaEventList() {
        $clubMediaEvents = ClubMedia::query()->get();
        return new ClubMediaCollection($clubMediaEvents);
    }

    public function store(ClubMediaRequest $request)
    {
        $data = $request;

        $parameters = [
            'image_info' => [
                [
                    'type' => 'media_main_image',
                    'images' => $data->media_main_image,
                    'directory' => 'club_media',
                    'input_field' => 'media_main_image',
                    'width' => '140',
                    'height' => '120',
                ],
            ],
        ];

        $clubMedia = $this->clubMedia->create($data, $parameters);

        // Data insert in seo table
        $seo = new Seo();
        $seo->model_name = 'App\Models\ClubMedia';
        $seo->model_id = $clubMedia->id;
        $seo->site = 'ccc';
        $seo->page_url = $request->seo_url;
        $seo->title = $clubMedia->title;
        $seo->keywords = 'club media, media';
        $seo->description = Str::limit(strip_tags($clubMedia->description), 100);
        $seo->save();

        return response()->json([
            'data' => $clubMedia,
            'message' => "Club Media Created Successfully",
            ], 200);
    }

    public function typeWiseMedia($shortName,$type)
    {
        $club = Club::where('short_name',$shortName)->first();
        $clubMedia = ClubMedia::query()->with('clubMediaPhoto')->where('club_id',$club->id)->where('type',$type)->get();

        return response()->json($clubMedia);
    }

    public function getMediaByTitle($slug)
    {
        $title = str_replace('-', ' ', $slug);
        $clubMedia = ClubMedia::query()->with('clubMediaPhoto')->where('title', 'LIKE', '%' . $title . '%')->first();

        return response()->json($clubMedia);
    }

    public function show($id)
    {
        $clubMedia = $this->clubMedia->with(['clubMediaPhoto'])->findOrFail($id);

        return response()->json($clubMedia);
    }

    public function edit($id)
    {
        $clubMedia = $this->clubMedia->with(['clubMediaMainLogo','clubMediaHeaderLogo','linkDetails'])->findOrFail($id);

        return response()->json($clubMedia);
    }

    public function update(ClubMediaRequest $request)
    {
        $data = $request;

        $parameters = [
            'image_info' => [
                [
                    'type' => 'media_main_image',
                    'images' => $data->media_main_image,
                    'directory' => 'club_media',
                    'input_field' => 'media_main_image',
                    'width' => '140',
                    'height' => '120',
                ],
            ],
        ];

        $clubMedia = $this->clubMedia->update($request->id, $data, $parameters);

        // Update or create the SEO entry
        Seo::updateOrCreate(
            ['model_name' => 'App\Models\ClubMedia', 'model_id' => $clubMedia->id],
            [
                'site' => 'ccc',
                'page_url' => $request->seo_url,
                'title' => $clubMedia->title,
                'keywords' => 'club media, media',
                'description' => Str::limit(strip_tags($clubMedia->description), 100),
            ]
        );

        return response()->json([
            'data' => $clubMedia,
            'message' => "Club Media Updated Successfully",
        ], 200);
    }

    public function destroy($id)
    {
        $this->clubMedia->delete($id);

        return response()->json([
            'message' => "Club-Media deleted Successfully",
        ], 200);
    }

    public function restore($id)
    {
        $this->clubMedia->restore($id);

        return response()->json([
            'message' => trans('clubMedia.restored'),
        ], 200);
    }

    public function forceDelete($id)
    {
        $this->clubMedia->forceDelete($id);

        return response()->json([
            'message' => trans('clubMedia.permanent_deleted'),
        ], 200);
    }

    public function status(Request $request)
    {
        $this->clubMedia->status($request->id);

        return response()->json([
            'message' => trans('clubMedia.status_updated'),
        ], 200);
    }
}
