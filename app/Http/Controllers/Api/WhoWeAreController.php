<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\WhoWeAreCollection;
use App\Http\Resources\WhoWeAreResource;
use App\Interfaces\WhoWeAreInterface;
use App\Models\WhoWeAre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class WhoWeAreController extends Controller
{
    protected $whoWeAre;

    public function __construct(WhoWeAreInterface $whoWeAre)
    {
        $this->whoWeAre=$whoWeAre;
    }

    public function index()
    {
        if (request()->per_page && request()->type == 'alumni') {
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;

            $query = WhoWeAre::query()
                ->where('type', request()->type)
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orderBy('id', 'asc')
                ->paginate($perPage);

            return new WhoWeAreCollection($query);
        } elseif (request()->per_page){
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;

            $query = WhoWeAre::query()
                ->where('type', 'ccc')
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orderBy('id', 'asc')
                ->paginate($perPage);

            return new WhoWeAreCollection($query);
        } else{
            if (request()->type == 'alumni') {
                $whoWeAre = WhoWeAre::query()->where('type', request()->type)->where('status', 'Active')->first();
            } else {

                $whoWeAre = WhoWeAre::query()->where('type', 'ccc')->where('status','Active')->first();

                $youtubeUrl =  $whoWeAre->video_url;

                $videoId = '';
                parse_str(parse_url($youtubeUrl, PHP_URL_QUERY), $params);
                if (isset($params['v'])) {
                    $videoId = $params['v'];
                } elseif (strpos($youtubeUrl, 'youtu.be') !== false) {
                    $path = parse_url($youtubeUrl, PHP_URL_PATH);
                    $videoId = ltrim($path, '/');
                }
                $whoWeAre['youtube_video_id'] = "https://www.youtube.com/embed/".$videoId;
                if ($whoWeAre->whoWeAre){
                    $whoWeAre['video'] = $whoWeAre->whoWeAre->source;
                }
            }
            return response()->json($whoWeAre);
        }
    }

    public function deletedListIndex()
    {
        $whoWeAre = $this->whoWeAre->onlyTrashed();
        return response()->json($whoWeAre);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        // $whoWeAre = $this->whoWeAre->create($request);

        $data = $request;
        $parameters = [
            'file_info' => [
                [
                    'type' => 'whoWeAre',
                    'files' => $data->video,
                    'directory' => 'whoWeAre',
                    'input_field' => 'video',
                ],
            ],
        ];
        $whoWeAre = $this->whoWeAre->create($data, $parameters);

        return response()->json([
            'data' => $whoWeAre,
            'message' => 'Who-We-Are Created Successfully',
        ], 200);

        /*$whoWeAre = new WhoWeAre();
        $whoWeAre->title = $request->title;
        $whoWeAre->description = $request->description;
        $whoWeAre->status = $request->status;
        if($request->file('video')){
            $file = $request->file('video');
            $filename = $file->getClientOriginalName();
            $path = public_path().'/uploads/video/';
            $file->move($path, $filename);
            $whoWeAre->video = URL::to('/uploads/video/'.$filename);
        }
        $whoWeAre->save();

        return new WhoWeAreResource($whoWeAre);*/
    }

    public function show(WhoWeAre $whoWeAre)
    {
        $whoWeAre = $this->whoWeAre->findOrFail($whoWeAre->id);
        return response()->json($whoWeAre);
    }

    public function edit(WhoWeAre $whoWeAre)
    {
        $whoWeAre = $this->whoWeAre->findOrFail($whoWeAre->id);
        return response()->json($whoWeAre);
    }

    public function update(Request $request, WhoWeAre $whoWeAre)
    {
        $whoWeAre = $this->whoWeAre->update($whoWeAre->id,$request);
        $request['update'] = 'update';
        return new WhoWeAreResource($whoWeAre);
    }

    public function destroy(WhoWeAre $whoWeAre)
    {
        $this->whoWeAre->delete($whoWeAre->id);
        return response()->json([
            'message' => trans('whoWeAre.deleted'),
        ], 200);
    }

    public function restore($id)
    {
        $this->whoWeAre->restore($id);
        return response()->json([
            'message' => trans('whoWeAre.restored'),
        ], 200);
    }

    public function forceDelete($id)
    {
        $this->whoWeAre->forceDelete($id);
        return response()->json([
            'message' => trans('whoWeAre.permanent_deleted'),
        ], 200);
    }

    public function status(Request $request)
    {
        $this->whoWeAre->status($request->id);
        return response()->json([
            'message' => trans('whoWeAre.status_updated'),
        ], 200);
    }
}
