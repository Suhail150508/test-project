<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ClubCommitteeRequest;
use App\Http\Resources\ClubCommitteeCollection;
use App\Interfaces\ClubCommitteeInterface;
use App\Models\Club;
use App\Models\ClubCommittee;
use Illuminate\Http\Request;

class ClubCommitteeController extends Controller
{
    protected $clubCommittee;

    public function __construct(ClubCommitteeInterface $clubCommittee)
    {
        $this->clubCommittee=$clubCommittee;
    }

    public function clubCommitteeIndex($shortName)
    {
        if (request()->per_page) {
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;
            $club = Club::where('short_name',$shortName)->first();
            $query = ClubCommittee::query()
                ->with('designation','department')
                ->where('club_id', $club->id)
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orderBy('id', 'asc')
                ->paginate($perPage);

            return new ClubCommitteeCollection($query);
        }else{
            $club = Club::where('short_name',$shortName)->first();
            $clubCommittee = ClubCommittee::query()->with('designation','department')->where('club_id', $club->id)->get();
            return new ClubCommitteeCollection($clubCommittee);
        }
    }

    public function deletedListIndex($club_id)
    {
        if (request()->per_page) {
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;

            $query = ClubCommittee::query()
                ->with('designation','department')
                ->where('club_id', $club_id)
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orderBy('id', 'asc')
                ->onlyTrashed()
                ->paginate($perPage);

            return new ClubCommitteeCollection($query);
        }else{
            $clubCommittee = ClubCommittee::query()->with('designation','department')->where('club_id', $club_id)->onlyTrashed()->get();
            return new ClubCommitteeCollection($clubCommittee);
        }
    }

    public function store(ClubCommitteeRequest $request)
    {
        $data = $request;

        $parameters = [
            'image_info' => [
                [
                    'type' => 'committee_image',
                    'images' => $data->committee_image,
                    'directory' => 'club_committee',
                    'input_field' => 'committee_image',
                    'width' => '140',
                    'height' => '120',
                ],
            ],
        ];

        $clubCommittee = $this->clubCommittee->create($data, $parameters);

        return response()->json([
            'data' => $clubCommittee,
            'message' => "Club Committee Created Successfully",
        ], 200);
    }

    public function show(ClubCommittee $clubCommittee)
    {
        $clubCommittee = $this->clubCommittee->with(['designation','department'])->findOrFail($clubCommittee->id);
        $clubCommittee['committee_image'] =  $clubCommittee->committee_image->source;
        return response()->json($clubCommittee);
    }

    public function edit($id)
    {
        $clubCommittee = $this->clubCommittee->with(['clubCommitteeMainLogo','clubCommitteeHeaderLogo','linkDetails'])->findOrFail($id);

        return response()->json($clubCommittee);
    }

    public function update(ClubCommitteeRequest $request)
    {
        $data = $request;
        $parameters = [
            'image_info' => [
                [
                    'type' => 'committee_image',
                    'images' => $data->committee_image,
                    'directory' => 'club_committee',
                    'input_field' => 'committee_image',
                    'width' => '140',
                    'height' => '120',
                ],
            ],
        ];

        $clubCommittee = $this->clubCommittee->update($request->id, $data, $parameters);

        return response()->json([
            'data' => $clubCommittee,
            'message' => "Club Moderator Updated Successfully",
        ], 200);
    }

    public function destroy($id)
    {
        $this->clubCommittee->delete($id);

        return response()->json([
            'message' => "Club-Committee deleted Successfully",
        ], 200);
    }

    public function restore($id)
    {
        $this->clubCommittee->restore($id);

        return response()->json([
            'message' => trans('clubCommittee.restored'),
        ], 200);
    }

    public function forceDelete($id)
    {
        $this->clubCommittee->forceDelete($id);

        return response()->json([
            'message' => trans('clubCommittee.permanent_deleted'),
        ], 200);
    }

    public function status(Request $request)
    {
        $this->clubCommittee->status($request->id);

        return response()->json([
            'message' => trans('clubCommittee.status_updated'),
        ], 200);
    }
}
