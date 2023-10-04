<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ClubModeratorRequest;
use App\Http\Resources\ClubModeratorCollection;
use App\Interfaces\ClubModeratorInterface;
use App\Models\Club;
use App\Models\ClubModerator;
use Illuminate\Http\Request;

class ClubModeratorController extends Controller
{
    protected $clubModerator;

    public function __construct(ClubModeratorInterface $clubModerator)
    {
        $this->clubModerator=$clubModerator;
    }

    public function clubModeratorIndex($shortName)
    {
        if (request()->per_page) {
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;
            $club = Club::where('short_name',$shortName)->first();
            $query = ClubModerator::query()
                ->with('designation','department')
                ->where('club_id', $club->id)
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orderBy('id', 'asc')
                ->paginate($perPage);

            return new ClubModeratorCollection($query);
        }else{
            $club = Club::where('short_name',$shortName)->first();
            $clubModerator = ClubModerator::query()->with('designation','department')->where('club_id', $club->id)->get();
            return new ClubModeratorCollection($clubModerator);
        }
    }

    public function deletedListIndex($club_id)
    {
        if (request()->per_page) {
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;

            $query = ClubModerator::query()
                ->with('designation','department')
                ->where('club_id', $club_id)
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orderBy('id', 'asc')
                ->onlyTrashed()
                ->paginate($perPage);

            return new ClubModeratorCollection($query);
        }else{
            $clubModerator = ClubModerator::query()->with('designation','department')->where('club_id', $club_id)->onlyTrashed()->get();
            return new ClubModeratorCollection($clubModerator);
        }
    }

    public function store(ClubModeratorRequest $request)
    {
        $data = $request;

        $parameters = [
            'image_info' => [
                [
                    'type' => 'moderator_image',
                    'images' => $data->moderator_image,
                    'directory' => 'club_moderator',
                    'input_field' => 'moderator_image',
                    'width' => '140',
                    'height' => '120',
                ],
            ],
        ];

        $clubModerator = $this->clubModerator->create($data, $parameters);

        return response()->json([
            'data' => $clubModerator,
            'message' => "Club Moderator Created Successfully",
        ], 200);
    }

    public function show(ClubModerator $clubModerator)
    {
        $clubModerator = $this->clubModerator->with(['designation','department'])->findOrFail($clubModerator->id);
        $clubModerator['moderator_image'] =  $clubModerator->moderator_image->source;
        return response()->json($clubModerator);
    }

    public function edit($id)
    {
        $clubModerator = $this->clubModerator->with(['clubModeratorMainLogo','clubModeratorHeaderLogo','linkDetails'])->findOrFail($id);

        return response()->json($clubModerator);
    }

    public function update(ClubModeratorRequest $request)
    {
        $data = $request;
        $parameters = [
            'image_info' => [
                [
                    'type' => 'moderator_image',
                    'images' => $data->moderator_image,
                    'directory' => 'club_moderator',
                    'input_field' => 'moderator_image',
                    'width' => '140',
                    'height' => '120',
                ],
            ],
        ];

        $clubModerator = $this->clubModerator->update($request->id, $data, $parameters);

        return response()->json([
            'data' => $clubModerator,
            'message' => "Club Moderator Updated Successfully",
        ], 200);
    }

    public function destroy($id)
    {
        $this->clubModerator->delete($id);

        return response()->json([
            'message' => "Club-Moderator deleted Successfully",
        ], 200);
    }

    public function restore($id)
    {
        $this->clubModerator->restore($id);

        return response()->json([
            'message' => trans('clubModerator.restored'),
        ], 200);
    }

    public function forceDelete($id)
    {
        $this->clubModerator->forceDelete($id);

        return response()->json([
            'message' => trans('clubModerator.permanent_deleted'),
        ], 200);
    }

    public function status(Request $request)
    {
        $this->clubModerator->status($request->id);

        return response()->json([
            'message' => trans('clubModerator.status_updated'),
        ], 200);
    }
}
