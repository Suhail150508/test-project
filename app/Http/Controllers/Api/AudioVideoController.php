<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AudioVideo;
use App\Http\Resources\AudioVideoCollection;
use App\Interfaces\AudioVideoInterface;
use App\Jobs\LargeFileUploadJob;
class AudioVideoController extends Controller
{
    protected $audiovideo;

    public function __construct(AudioVideoInterface $audiovideo){
        $this->audiovideo = $audiovideo;
    }
    public function index()
    {
        $perPage = request()->per_page;
        $fieldName = request()->field_name;
        $keyword = request()->keyword;

        $query = AudioVideo::query()
            ->with('ccc_audiovideo')
            ->where($fieldName, 'LIKE', "%$keyword%")
            ->orderBy('id', 'desc')
            ->paginate($perPage);

            return new AudioVideoCollection($query);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        dispatch(new LargeFileUploadJob("hello"));

        // $file =  $request->file('file');
        // $fileName=hexdec(uniqid()).'.'.$file->extension();
        // $file->move('upload',$fileName);
        // $insert = new AudioVideo();
        // $insert->title = $request->title;
        // $insert->description = $request->description;
        // $insert->file = $fileName;
        // $insert->save();

    return response()->json(['success']);









        // $data = $request;
        // $data['created_by'] = 2;

        // $parameters = [
        //     'image_info' => [
        //         [
        //             'type' => 'ccc_audiovideo',
        //             'images' => $data->file,
        //             'directory' => 'audiovideos',
        //             'input_field' => 'file',
        //             'width' => '',
        //             'height' => '',
        //         ],
        //     ],
        // ];

        // $audiovideo = $this->audiovideo->create($data, $parameters);


        // return response()->json($audiovideo);

        // return new CccNewsResource($cccNews);
    }

    

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, AudioVideo $audio_video)
    {

        $data = $request;
        $data['created_by'] = 2;

        $parameters = [
            'image_info' => [
                [
                    'type' => 'ccc_audiovideo',
                    'images' => $data->file,
                    'directory' => 'audiovideos',
                    'input_field' => 'file',
                    'width' => '',
                    'height' => '',
                ],
            ],
        ];

        $audiovideo = $this->audiovideo->update($audio_video->id,$data, $parameters);


        return response()->json($audiovideo);
    }


    public function destroy($id)
    {
        //
    }
}
