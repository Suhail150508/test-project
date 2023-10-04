<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ClassMemoriesNewsFeed;
use App\Interfaces\ClassMemoriesNewsFeedInterface;
use App\Http\Resources\ClassMemoriesNewsFeedResource;
use App\Http\Resources\ClassMemoriesNewsFeedCollection;

class ClassMemoriesNewsFeedController extends Controller
{
    protected $classMemoriesNewsFeed;

    public function __construct(ClassMemoriesNewsFeedInterface $classMemoriesNewsFeed)
    {
        $this->classMemoriesNewsFeed = $classMemoriesNewsFeed;
    }

    public function index()
    {
        $classMemoriesId = request()->class_memories_id;
        $query = ClassMemoriesNewsFeed::with('alumni', 'alumni.alumni', 'alumni.backgroundImage', 'classMemoriesNewsFeedImage')->whereIn('class_memories_id', [$classMemoriesId])->orderBy('id', 'DESC')->get();

        return new ClassMemoriesNewsFeedCollection($query);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = $request;
            $parameters = [
                'image_info' => [
                    [
                        'type' => 'image',
                        'images' => $data->image,
                        'directory' => 'class_memories_news_feed',
                        'input_field' => 'image',
                        'width' => '',
                        'height' => '',
                    ],
                ],
            ];

            $classMemoriesNewsFeed = $this->classMemoriesNewsFeed->create($data, $parameters);
            DB::commit();

            return new ClassMemoriesNewsFeedResource($classMemoriesNewsFeed);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }

    public function show(ClassMemoriesNewsFeed $classMemoriesNewsFeed)
    {

    }

    public function update(Request $request, ClassMemoriesNewsFeed $classMemoriesNewsFeed)
    {
        try {
            DB::beginTransaction();
            $data = $request;
            $parameters = [
                'image_info' => [
                    [
                        'type' => 'image',
                        'images' => $data->image,
                        'directory' => 'class_memories_news_feed',
                        'input_field' => 'image',
                        'width' => '',
                        'height' => '',
                    ],
                ],
            ];
            $classMemoriesNewsFeed = $this->classMemoriesNewsFeed->update($classMemoriesNewsFeed->id, $data, $parameters);
            DB::commit();

            return new ClassMemoriesNewsFeedResource($classMemoriesNewsFeed);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }

    public function destroy(ClassMemoriesNewsFeed $classMemoriesNewsFeed)
    {
        try {
            DB::beginTransaction();
            $postDelete = $this->classMemoriesNewsFeed->delete($classMemoriesNewsFeed->id);
            $postFilesDelete = $classMemoriesNewsFeed->classMemoriesNewsFeedFiles()->delete();
            DB::commit();

            return response()->json($postDelete, $postFilesDelete);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }
}
