<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ClassMemoriesMember;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClassMemoriesResource;
use App\Models\ClassMemories;
use App\Models\ClassMemoriesRole;

class ClassMemoriesMemberController extends Controller
{
    public function classMemoriesSuggestionList()
    {
        try {
            $classMemoriesIds = ClassMemoriesMember::query()
                ->where('alumni_id', request()->auth_id)
                ->where('status', 'accept')
                ->pluck('class_memories_id');

            $classMemories = ClassMemories::with(['classMemoriesMembers', 'classMemoriesMembers.alumni'])->whereNot('user_id', request()->auth_id)->whereNotIn('id', $classMemoriesIds)->get();

            foreach ($classMemories as $key => $classMemory) {
                $classMemoriesMemberCount = $classMemory->classMemoriesMembers->where('status', 'accept')->count();
                $classMemory['totalMember'] = $classMemoriesMemberCount;
            }

            return ClassMemoriesResource::collection($classMemories);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }

    public function sendClassMemoriesJoinRequest($classMemoriesId)
    {
        try {
            $classMemories = new ClassMemoriesMember();
            $classMemories->class_memories_id = $classMemoriesId;
            $classMemories->alumni_id = request()->auth_id;
            $classMemories->status = 'pending';
            $classMemories->save();

            return response()->json([
                'data' => $classMemories,
                'message' => 'Successfully request sent',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }

    public function cancelClassMemoriesJoinRequest($classMemoriesId)
    {
        $classMemoriesMember = ClassMemoriesMember::where('class_memories_id', $classMemoriesId)->where('alumni_id', request()->auth_id)->first()->delete();
        return response()->json([
            'data' => $classMemoriesMember,
            'message' => 'Join request withdrow Successfully',
        ], 200);
    }

    public function leaveThisClassMemories($classMemoriesId)
    {
        $classMemoriesMember = ClassMemoriesMember::where('class_memories_id', $classMemoriesId)->where('alumni_id', request()->auth_id)->first()->delete();

        return response()->json([
            'data' => $classMemoriesMember,
            'message' => 'You leave this class memories Successfully',
        ], 200);
    }

    public function getClassMemoriesMemberRequestList($classMemoriesId) {
        $classMemoriesMembers = ClassMemoriesMember::with('alumni', 'alumni.alumni')->where('class_memories_id', $classMemoriesId)->where('status', 'pending')->get();

        return response()->json([
            'data' => $classMemoriesMembers,
        ], 200);
    }

    public function denyClassMemoriesMemberRequest($classMemoriesId, $memberId) {
        $classMemoriesMember = ClassMemoriesMember::where('class_memories_id', $classMemoriesId)->where('alumni_id', $memberId)->first()->delete();

        return response()->json([
            'data' => $classMemoriesMember,
            'message' => 'Deny member request Successfully',
        ], 200);
    }

    public function acceptClassMemoriesMemberRequest($classMemoriesId, $memberId) {
        $classMemoriesMember = ClassMemoriesMember::where('class_memories_id', $classMemoriesId)->where('alumni_id', $memberId)->first();
        $classMemoriesMember->update([
            'status' => 'accept'
        ]);

        return response()->json([
            'data' => $classMemoriesMember,
            'message' => 'Accept member request Successfully',
        ], 200);
    }

    public function getJoinedClassMemoriesList($userId)
    {
        $classMemoriesIds = ClassMemoriesMember::where('alumni_id', $userId)->where('status', 'accept')->pluck('class_memories_id');
        $classMemories = ClassMemories::with(['profileImage'])->whereIn('id', $classMemoriesIds)->get();
        foreach ($classMemories as $key => $classMemory) {
            $classMemoriesMemberCount = $classMemory->classMemoriesMembers->where('status', 'accept')->count();
            $classMemory['totalMember'] = $classMemoriesMemberCount;
        }

        return response()->json([
            'data' => $classMemories,
        ], 200);
    }

    public function sendJoiningRequestClassMemoriesList($userId) {
        $classMemoriesIds = ClassMemoriesMember::where('alumni_id', $userId)->where('status', 'pending')->pluck('class_memories_id');
        $classMemories = ClassMemories::with(['profileImage'])->whereIn('id', $classMemoriesIds)->get();
        foreach ($classMemories as $key => $classMemory) {
            $classMemoriesMemberCount = $classMemory->classMemoriesMembers->where('status', 'accept')->count();
            $classMemory['totalMember'] = $classMemoriesMemberCount;
        }

        return response()->json([
            'data' => $classMemories,
        ], 200);
    }

    public function getClassMemoriesMemberList($classMemoriesId)
    {
        $members = ClassMemoriesMember::with('alumni', 'alumni.alumni', 'classMemories')->where('class_memories_id', $classMemoriesId)->where('status', 'accept')->get();
        foreach ($members as $member) {
            if ($member->class_memories_role_ids) {
                $classMemoriesRole = ClassMemoriesRole::whereIn('id', json_decode($member->class_memories_role_ids))->get();
                $member['class_memories_roles'] = $classMemoriesRole;
            }
        }

        return response()->json([
            'data' => $members,
        ], 200);
    }

    public function getClassMemoriesRoles()
    {
        $classMemoriesRoles = ClassMemoriesRole::get();

        return response()->json([
            'data' => $classMemoriesRoles,
        ], 200);
    }

    public function addClassMemoriesPermission($classMemoriesMemberId)
    {
        ClassMemoriesMember::findOrFail($classMemoriesMemberId)->update([
            'class_memories_role_ids' => json_encode(request()->permission),
        ]);

        return response()->noContent();
    }
}
