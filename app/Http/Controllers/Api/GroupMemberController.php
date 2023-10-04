<?php

namespace App\Http\Controllers\Api;

use App\Models\Group;
use App\Models\GroupMember;
use Illuminate\Http\Request;
use App\Interfaces\GroupInterface;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\GroupCollection;
use App\Models\GroupRole;
use Request as GlobalRequest;

class GroupMemberController extends Controller
{
    protected $group;

    public function __construct(GroupInterface $group)
    {
        $this->group = $group;
    }

    public function getSuggestionGroups()
    {
        try {
            $groupIds = GroupMember::query()
                ->where('alumni_id', request()->auth_id)
                ->where('status', 'accept')
                ->pluck('group_id');

            $groups = Group::with(['groupMembers', 'groupMembers.alumni'])->whereNot('user_id', request()->auth_id)->whereNotIn('id', $groupIds)->get();

            foreach ($groups as $key => $group) {
                $groupMemberCount = $group->groupMembers->where('status', 'accept')->count();
                $group['totalMember'] = $groupMemberCount;
            }

            return new GroupCollection($groups);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }

    public function sendGroupJoinRequest($group_id)
    {
        try {
            $groupMember = new GroupMember();
            $groupMember->group_id = $group_id;
            $groupMember->alumni_id = request()->auth_id;
            $groupMember->status = 'pending';
            $groupMember->save();

            return response()->json([
                'data' => $groupMember,
                'message' => 'Successfully request sent',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }

    public function cancelGroupJoinRequest($group_id) {
        $groupMember = GroupMember::where('group_id', $group_id)->where('alumni_id', request()->auth_id)->first()->delete();
        return response()->json([
            'data' => $groupMember,
            'message' => 'Join request withdrow Successfully',
        ], 200);
    }

    public function leaveThisGroup($group_id) {
        $groupMember = GroupMember::where('group_id', $group_id)->where('alumni_id', request()->auth_id)->first()->delete();
        return response()->json([
            'data' => $groupMember,
            'message' => 'You leave this group Successfully',
        ], 200);
    }

    public function getUserJoiningGroupList($user_id) {
        $groups = GroupMember::with('group', 'group.groupMembers', 'group.profileImage', 'group.backgroundImage')->where('alumni_id', $user_id)->where('status', 'accept')->get();
        // return new GroupCollection($groups);
        return response()->json([
            'data' => $groups,
        ], 200);
    }

    public function getSendJoiningRequestGroupList($user_id) {
        $groups = GroupMember::with('group', 'group.groupMembers', 'group.profileImage', 'group.backgroundImage')->where('alumni_id', $user_id)->where('status', 'pending')->get();
        return response()->json([
            'data' => $groups,
        ], 200);
    }

    public function getReceiveJoiningRequestGroupMemberList($group_id) {
        $groups = GroupMember::with('alumni', 'alumni.alumni')->where('group_id', $group_id)->where('status', 'pending')->get();
        return response()->json([
            'data' => $groups,
        ], 200);
    }

    public function denyGroupJoinRequest ($group_id, $member_id) {
        $groupMember = GroupMember::where('group_id', $group_id)->where('alumni_id', $member_id)->first()->delete();
        return response()->json([
            'data' => $groupMember,
            'message' => 'Deny member request Successfully',
        ], 200);
    }

    public function acceptGroupJoinRequest ($group_id, $member_id) {
        $groupMember = GroupMember::where('group_id', $group_id)->where('alumni_id', $member_id)->first();
        $groupMember->update([
            'status' => 'accept'
        ]);
        return response()->json([
            'data' => $groupMember,
            'message' => 'Accept member request Successfully',
        ], 200);
    }

    public function getGroupMemberList($group_id) {
        $members = GroupMember::with('alumni', 'alumni.alumni', 'group')->where('group_id', $group_id)->where('status', 'accept')->get();
        foreach($members as $member) {
            if($member->group_role_ids) {
                $group_role = GroupRole::whereIn('id', json_decode($member->group_role_ids))->get();
                $member['group_roles'] = $group_role;
            }
        }

        return response()->json([
            'data' => $members,
        ], 200);
    }

    public function getGroupRoles() {
        $groupRoles = GroupRole::get();

        return response()->json([
            'data' => $groupRoles,
        ], 200);
    }

    public function addGroupPermission($group_member_id) {
        // dd(request()->all());
        GroupMember::findOrFail($group_member_id)->update([
            'group_role_ids' => json_encode(request()->permission),
        ]);

        return response()->noContent();
    }
}
