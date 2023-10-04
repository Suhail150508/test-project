<?php

namespace App\Http\Controllers\Api;

use App\Models\NewsFeed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Interfaces\NewsFeedInterface;
use App\Http\Resources\NewsFeedResource;
use App\Http\Resources\NewsFeedCollection;
use App\Http\Requests\Admin\NewsFeedRequest;

class NewsFeedController extends Controller
{
    protected $newsFeed;

    public function __construct(NewsFeedInterface $newsFeed)
    {
        $this->newsFeed = $newsFeed;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $authId = request()->auth_id;
        if (request()->page_name == "home") {
            // $query = NewsFeed::with('alumni', 'alumni.alumni', 'alumni.backgroundImage', 'newsFeedImage', 'newsFeedVideo', 'newsFeedDocument')->whereNotIn('alumni_id', [$authId])->orderBy('id', 'DESC')->get();
            $query = NewsFeed::with('alumni', 'alumni.alumni', 'alumni.backgroundImage', 'newsFeedImage', 'newsFeedVideo', 'newsFeedDocument')->orderBy('id', 'DESC')->get();
        } elseif (request()->page_name == "profile") {
            $query = NewsFeed::with('alumni', 'alumni.alumni', 'alumni.backgroundImage', 'newsFeedImage', 'newsFeedVideo', 'newsFeedDocument')->whereIn('alumni_id', [$authId])->orderBy('id', 'DESC')->get();
        }

        return new NewsFeedCollection($query);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewsFeedRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request;
            $parameters = [
                'image_info' => [
                    [
                        'type' => 'image',
                        'images' => $data->image,
                        'directory' => 'news_feed',
                        'input_field' => 'image',
                        'width' => '',
                        'height' => '',
                    ],
                ],

                'file_info' => [
                    [
                        'type' => 'video',
                        'files' => $data->video,
                        'directory' => 'news_feed/videos',
                        'input_field' => 'video',
                    ],
                    [
                        'type' => 'document',
                        'files' => $data->document,
                        'directory' => 'news_feed/document',
                        'input_field' => 'document',
                    ],
                ],
            ];

            $newsFeed = $this->newsFeed->create($data, $parameters);
            DB::commit();

            return new NewsFeedResource($newsFeed);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NewsFeed  $newsFeed
     * @return \Illuminate\Http\Response
     */
    public function show(NewsFeed $newsFeed)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NewsFeed  $newsFeed
     * @return \Illuminate\Http\Response
     */
    public function edit(NewsFeed $newsFeed)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NewsFeed  $newsFeed
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NewsFeed $newsFeed)
    {
        try {
            DB::beginTransaction();
            $data = $request;

            $parameters = [
                'image_info' => [
                    [
                        'type' => 'image',
                        'images' => $data->image,
                        'directory' => 'news_feed',
                        'input_field' => 'image',
                        'width' => '',
                        'height' => '',
                    ],
                ],

                'file_info' => [
                    [
                        'type' => 'video',
                        'files' => $data->video,
                        'directory' => 'news_feed/videos',
                        'input_field' => 'video',
                    ],
                    [
                        'type' => 'document',
                        'files' => $data->document,
                        'directory' => 'news_feed/document',
                        'input_field' => 'document',
                    ],
                ],
            ];

            // dd($parameters, $data);
            $newsFeed = $this->newsFeed->update($newsFeed->id, $data, $parameters);
            DB::commit();

            return new NewsFeedResource($newsFeed);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NewsFeed  $newsFeed
     * @return \Illuminate\Http\Response
     */
    public function destroy(NewsFeed $newsFeed)
    {
        try {
            DB::beginTransaction();
            $newsFeedDelete = $this->newsFeed->delete($newsFeed->id);
            $newsFeedFilesDelete = $newsFeed->newsFeedFiles()->delete();
            DB::commit();

            return response()->json($newsFeedDelete, $newsFeedFilesDelete);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }
}
