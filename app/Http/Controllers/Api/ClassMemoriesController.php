<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\ClassMemories;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClassMemoriesResource;
use App\Interfaces\ClassMemoriesInterface;
use App\Models\ClassMemoriesMember;

class ClassMemoriesController extends Controller
{
    protected $classMemories;

    public function __construct(ClassMemoriesInterface $classMemories)
    {
        $this->classMemories = $classMemories;
    }

    public function index()
    {
        $classMemories = ClassMemories::query()
            ->with(['classMemoriesMembers', 'classMemoriesMembers.alumni'])
            ->where('user_id', request()->user_id)
            ->where('user_type', request()->user_type)
            ->get();
        foreach ($classMemories as $key => $classMemorie) {
            $classMemoriesMemberCount = $classMemorie->classMemoriesMembers->where('status', 'accept')->count();
            $classMemorie['totalMember'] = $classMemoriesMemberCount;
        }

        return ClassMemoriesResource::collection($classMemories);
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = $request;
            $parameters = [
                'image_info' => [
                    [
                        'type' => 'class-memories-background',
                        'images' => $data->background_image,
                        'directory' => 'class_memories/background',
                        'input_field' => 'backgroud_image',
                        'width' => '',
                        'height' => '',
                    ],
                    [
                        'type' => 'class-memories-profile',
                        'images' => $data->profile_image,
                        'directory' => 'class_memories/profile',
                        'input_field' => 'profile_image',
                        'width' => '',
                        'height' => '',
                    ],
                ],
            ];

            $classMemories = $this->classMemories->create($data, $parameters);
            ClassMemoriesMember::create([
                'class_memories_id' => $classMemories->id,
                'alumni_id' => $classMemories->user_id,
                'status' => 'accept',
                'class_memories_role_ids' => json_encode([1]),
            ]);
            DB::commit();

            return new ClassMemoriesResource($classMemories);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }

    public function show(ClassMemories $class_memory)
    {
        $classMemories = $this->classMemories->with(['alumni', 'backgroundImage', 'profileImage', 'classMemoriesMembers', 'classMemoriesMembers.alumni', 'classMemoriesMembers.alumni.alumni'])->findOrFail($class_memory->id);

        $classMemoriesMemberCount = $class_memory->classMemoriesMembers->where('status', 'accept')->count();
        $classMemories['totalMember'] = $classMemoriesMemberCount;

        return new ClassMemoriesResource($classMemories);
    }

    public function edit(ClassMemories $classMemories)
    {

    }

    public function update(Request $request, ClassMemories $class_memory)
    {
        try {
            DB::beginTransaction();
            $data = $request;
            $parameters = [
                'image_info' => [
                    [
                        'type' => 'class-memories-background',
                        'images' => $data->background_image,
                        'directory' => 'class_memories/background',
                        'input_field' => 'backgroud_image',
                        'width' => '',
                        'height' => '',
                    ],
                    [
                        'type' => 'class-memories-profile',
                        'images' => $data->profile_image,
                        'directory' => 'class_memories/profile',
                        'input_field' => 'profile_image',
                        'width' => '',
                        'height' => '',
                    ],
                ],
            ];

            $classMemories = $this->classMemories->update($class_memory->id, $data, $parameters);
            DB::commit();

            return new ClassMemoriesResource($classMemories);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }

    public function destroy(ClassMemories $class_memory)
    {
        $this->classMemories->delete($class_memory->id);
        return response()->noContent();
    }
}
