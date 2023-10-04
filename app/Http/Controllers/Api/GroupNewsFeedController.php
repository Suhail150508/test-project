<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\GroupNewsFeed;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\GroupNewsFeedCollection;
use App\Http\Resources\GroupNewsFeedResource;
use App\Interfaces\GroupNewsFeedInterface;

class GroupNewsFeedController extends Controller
{
    protected $groupNewsFeed;

    public function __construct(GroupNewsFeedInterface $groupNewsFeed)
    {
        $this->groupNewsFeed = $groupNewsFeed;
    }

    public function index()
    {
        $groupId = request()->group_id;
        $query = GroupNewsFeed::with('alumni', 'alumni.alumni', 'alumni.backgroundImage', 'groupNewsFeedImage', 'groupNewsFeedVideo', 'groupNewsFeedDocument')->whereIn('group_id', [$groupId])->orderBy('id', 'DESC')->get();

        return new GroupNewsFeedCollection($query);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        try {
            DB::beginTransaction();
            $data = $request;
            $parameters = [
                'image_info' => [
                    [
                        'type' => 'image',
                        'images' => $data->image,
                        'directory' => 'group_news_feed',
                        'input_field' => 'image',
                        'width' => '',
                        'height' => '',
                    ],
                ],

                'file_info' => [
                    [
                        'type' => 'video',
                        'files' => $data->video,
                        'directory' => 'group_news_feed/videos',
                        'input_field' => 'video',
                    ],
                    [
                        'type' => 'document',
                        'files' => $data->document,
                        'directory' => 'group_news_feed/documents',
                        'input_field' => 'document',
                    ],
                ],
            ];

            $groupNewsFeed = $this->groupNewsFeed->create($data, $parameters);
            DB::commit();

            return new GroupNewsFeedResource($groupNewsFeed);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }

    public function show(GroupNewsFeed $groupNewsFeed)
    {

    }

    public function update(Request $request, GroupNewsFeed $groupNewsFeed)
    {
        // dd($request->all());
        try {
            DB::beginTransaction();
            $data = $request;

            $parameters = [
                'image_info' => [
                    [
                        'type' => 'image',
                        'images' => $data->image,
                        'directory' => 'group_news_feed',
                        'input_field' => 'image',
                        'width' => '',
                        'height' => '',
                    ],
                ],

                'file_info' => [
                    [
                        'type' => 'video',
                        'files' => $data->video,
                        'directory' => 'group_news_feed/videos',
                        'input_field' => 'video',
                    ],
                    [
                        'type' => 'document',
                        'files' => $data->document,
                        'directory' => 'group_news_feed/documents',
                        'input_field' => 'document',
                    ],
                ],
            ];

            // dd($parameters);

            $groupNewsFeed = $this->groupNewsFeed->update($groupNewsFeed->id, $data, $parameters);
            DB::commit();

            return new GroupNewsFeedResource($groupNewsFeed);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }

    public function destroy(GroupNewsFeed $groupNewsFeed)
    {
        try {
            DB::beginTransaction();
            $groupPostDelete = $this->groupNewsFeed->delete($groupNewsFeed->id);
            $groupPostFilesDelete = $groupNewsFeed->groupNewsFeedFiles()->delete();
            DB::commit();

            return response()->json($groupPostDelete, $groupPostFilesDelete);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }
}
