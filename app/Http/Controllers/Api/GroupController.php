<?php

namespace App\Http\Controllers\Api;

use App\Models\Group;
use Illuminate\Http\Request;
use App\Interfaces\GroupInterface;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\GroupCollection;
use App\Http\Resources\GroupResource;
use App\Models\GroupMember;

class GroupController extends Controller
{
    protected $group;

    public function __construct(GroupInterface $group)
    {
        $this->group = $group;
    }

    public function index()
    {
        $groups = Group::query()
            ->with(['groupMembers', 'groupMembers.alumni'])
            ->where('user_id', request()->user_id)
            ->where('user_type', request()->user_type)
            ->get();
        foreach($groups as $key => $group) {
            $groupMemberCount = $group->groupMembers->where('status', 'accept')->count();
            $group['totalMember'] = $groupMemberCount;
        }

        return new GroupCollection($groups);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = $request;
            $parameters = [
                'image_info' => [
                    [
                        'type' => 'group-background',
                        'images' => $data->background_image,
                        'directory' => 'group/background',
                        'input_field' => 'backgroud_image',
                        'width' => '',
                        'height' => '',
                    ],
                    [
                        'type' => 'group-profile',
                        'images' => $data->profile_image,
                        'directory' => 'group/profile',
                        'input_field' => 'profile_image',
                        'width' => '',
                        'height' => '',
                    ],
                ],
            ];

            $group = $this->group->create($data, $parameters);
            GroupMember::create([
                'group_id' => $group->id,
                'alumni_id' => $group->user_id,
                'status' => 'accept',
                'group_role_ids' => json_encode([1]),
            ]);
            DB::commit();

            return new GroupResource($group);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }

    public function show(Group $group)
    {
        $groups = $this->group->with(['alumni', 'backgroundImage', 'profileImage', 'groupMembers', 'groupMembers.alumni'])->findOrFail($group->id);

        $groupMemberCount = $group->groupMembers->where('status', 'accept')->count();
        $groups['totalMember'] = $groupMemberCount;

        return new GroupResource($groups);
    }

    public function update(Request $request, Group $group)
    {
        try {
            DB::beginTransaction();
            $data = $request;
            $parameters = [
                'image_info' => [
                    [
                        'type' => 'group-background',
                        'images' => $data->background_image,
                        'directory' => 'group/background',
                        'input_field' => 'backgroud_image',
                        'width' => '',
                        'height' => '',
                    ],
                    [
                        'type' => 'group-profile',
                        'images' => $data->profile_image,
                        'directory' => 'group/profile',
                        'input_field' => 'profile_image',
                        'width' => '',
                        'height' => '',
                    ],
                ],
            ];

            $group = $this->group->update($group->id, $data, $parameters);
            DB::commit();

            return new GroupResource($group);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }

    public function destroy(Group $group)
    {
        $group = $this->group->delete($group->id);
        return response()->json($group);
    }
}
