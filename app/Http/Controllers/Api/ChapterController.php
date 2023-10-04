<?php

namespace App\Http\Controllers\Api;

use App\Models\Chapter;
use Illuminate\Http\Request;
use App\Models\ChapterMember;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Interfaces\ChapterInterface;
use App\Http\Resources\ChapterResource;

class ChapterController extends Controller
{
    protected $chapter;

    public function __construct(ChapterInterface $chapter)
    {
        $this->chapter = $chapter;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $chapters = Chapter::query()
            ->where('user_id', request()->user_id)
            ->where('user_type', request()->user_type)
            ->get();

        foreach ($chapters as $key => $chapter) {
            $memberCount = $chapter->chapterMembers->where('status', 'accept')->count();
            $chapter['totalMember'] = $memberCount;
        }

        return ChapterResource::collection($chapters);
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
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = $request;
            $parameters = [
                'image_info' => [
                    [
                        'type' => 'chapter-background',
                        'images' => $data->background_image,
                        'directory' => 'chapter/background',
                        'input_field' => 'backgroud_image',
                        'width' => '',
                        'height' => '',
                    ],
                    [
                        'type' => 'chapter-profile',
                        'images' => $data->profile_image,
                        'directory' => 'chapter/profile',
                        'input_field' => 'profile_image',
                        'width' => '',
                        'height' => '',
                    ],
                ],
            ];

            $chapter = $this->chapter->create($data, $parameters);
            ChapterMember::create([
                'chapter_id' => $chapter->id,
                'alumni_id' => $chapter->user_id,
                'status' => 'accept',
                'role' => 'admin',
            ]);
            DB::commit();

            return new ChapterResource($chapter);
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
     * @param  \App\Models\Chapter  $chapter
     * @return \Illuminate\Http\Response
     */
    public function show(Chapter $chapter)
    {
        $chapter = $this->chapter->with(['alumni', 'backgroundImage', 'profileImage', 'chapterMembers', 'chapterMembers.alumni'])->findOrFail($chapter->id);

        $chapterMemberCount = $chapter->chapterMembers->where('status', 'accept')->count();
        $chapter['totalMember'] = $chapterMemberCount;

        return new ChapterResource($chapter);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Chapter  $chapter
     * @return \Illuminate\Http\Response
     */
    public function edit(Chapter $chapter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Chapter  $chapter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Chapter $chapter)
    {
        try {
            DB::beginTransaction();
            $data = $request;
            $parameters = [
                'image_info' => [
                    [
                        'type' => 'chapter-background',
                        'images' => $data->background_image,
                        'directory' => 'chapter/background',
                        'input_field' => 'backgroud_image',
                        'width' => '',
                        'height' => '',
                    ],
                    [
                        'type' => 'chapter-profile',
                        'images' => $data->profile_image,
                        'directory' => 'chapter/profile',
                        'input_field' => 'profile_image',
                        'width' => '',
                        'height' => '',
                    ],
                ],
            ];

            $chapter = $this->chapter->update($chapter->id, $data, $parameters);
            $request['update'] = "update";
            DB::commit();

            return new ChapterResource($chapter);
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
     * @param  \App\Models\Chapter  $chapter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chapter $chapter)
    {
        $chapter = $this->chapter->delete($chapter->id);
        return response()->json($chapter);
    }
}
