<?php

namespace App\Http\Controllers\Api;

use App\Models\Chapter;
use Illuminate\Http\Request;
use App\Models\ChapterMember;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Interfaces\ChapterInterface;
use App\Http\Resources\ChapterResource;

class ChapterMemberController extends Controller
{
    protected $chapter;

    public function __construct(ChapterInterface $chapter)
    {
        $this->chapter = $chapter;
    }

    public function chapterSuggestionList()
    {
        try {
            DB::beginTransaction();
            $chapterIds = ChapterMember::query()
                ->where('alumni_id', request()->auth_id)
                ->where('status', 'accept')
                ->pluck('chapter_id');

            $chapters = Chapter::with(['chapterMembers', 'chapterMembers.alumni'])->whereNot('user_id', request()->auth_id)->whereNotIn('id', $chapterIds)->get();

            foreach ($chapters as $key => $chapter) {
                $memberCount = $chapter->chapterMembers->where('status', 'accept')->count();
                $chapter['totalMember'] = $memberCount;
            }
            DB::commit();

            return ChapterResource::collection($chapters);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }

    public function chapterSendJoiningRequest($chapter_id)
    {
        try {
            $chapterMember = new ChapterMember();
            $chapterMember->chapter_id = $chapter_id;
            $chapterMember->alumni_id = request()->auth_id;
            $chapterMember->status = 'pending';
            $chapterMember->save();

            return response()->json([
                'data' => $chapterMember,
                'message' => 'Successfully request sent',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }

    public function chapterCancelJoiningRequest($chapter_id) {
        $chapterMember = ChapterMember::where('chapter_id', $chapter_id)->where('alumni_id', request()->auth_id)->first()->delete();
        return response()->json([
            'data' => $chapterMember,
            'message' => 'Join request withdrow Successfully',
        ], 200);
    }

    public function chapterListWhereYouMember($alumni_id) {
        $chapters = ChapterMember::with('chapter', 'chapter.chapterMembers', 'chapter.profileImage', 'chapter.backgroundImage')->where('alumni_id', $alumni_id)->where('status', 'accept')->get();

        foreach ($chapters as $key => $chapter) {
            $memberCount = $chapter->chapter->chapterMembers->where('status', 'accept')->count();
            $chapter['chapter']['totalMember'] = $memberCount;
        }

        return response()->json([
            'data' => $chapters,
        ], 200);
    }

    public function chapterLeaveWhereYouMember($chapter_id) {
        $chapterMember = ChapterMember::where('chapter_id', $chapter_id)->where('alumni_id', request()->auth_id)->first()->delete();

        return response()->json([
            'data' => $chapterMember,
            'message' => 'You leave this chapter Successfully',
        ], 200);
    }

    public function chapterIncommingMemberRequestList($chapter_id)
    {
        $memberRequests = ChapterMember::with('alumni', 'alumni.alumni')->where('chapter_id', $chapter_id)->where('status', 'pending')->get();
        return response()->json([
            'data' => $memberRequests,
        ], 200);
    }

    public function chapterAcceptMemberJoiningRequest($chapter_id, $member_id)
    {
        $chapterMember = ChapterMember::where('chapter_id', $chapter_id)->where('alumni_id', $member_id)->first();
        $chapterMember->update([
            'status' => 'accept'
        ]);

        return response()->json([
            'data' => $chapterMember,
            'message' => 'Accept member request Successfully',
        ], 200);
    }

    public function chapterDenyMemberJoiningRequest($chapter_id, $member_id)
    {
        $chapterMember = ChapterMember::where('chapter_id', $chapter_id)->where('alumni_id', $member_id)->first()->delete();

        return response()->json([
            'data' => $chapterMember,
            'message' => 'Deny member request Successfully',
        ], 200);
    }

    public function chapterMemberList($chapter_id)
    {
        $members = ChapterMember::with('alumni', 'alumni.alumni', 'chapter')->where('chapter_id', $chapter_id)->where('status', 'accept')->get();

        return response()->json([
            'data' => $members,
        ], 200);
    }
}
