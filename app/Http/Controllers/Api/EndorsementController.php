<?php

namespace App\Http\Controllers\Api;

use App\Models\Alumni;
use App\Models\Endorsement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class EndorsementController extends Controller
{
    public function endorsementList()
    {
        $endorsements = Endorsement::query()->where('user_id', request()->user_id)->get();

        return response()->json([
            'endorsements' => $endorsements,
        ], 200);
    }

    public function addEndorsement()
    {
        try {
            DB::beginTransaction();
            Endorsement::create([
                'user_id' => request()->user_id,
                'endorser_id' => request()->endorser_id,
                'activity_type' => request()->activity_type,
                'activity_id' => request()->activity_id,
            ]);

            // $alumni = Alumni::findOrFail(request()->user_id);
            // $aaa = $alumni->skills()->where('skillable_id', 7)->where('skill_id', 1)->first();
            // $alumni->skills()->updateExistingPivot($aaa->pivot->skill_id, ['endorse' => request()->endorse_user_id]);
            DB::commit();

            return response()->json([
                'message' => 'Successfully add endorsement',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }

    public function cancelEndorsement()
    {
        $endorsement = Endorsement::where('user_id', request()->user_id)->where('endorser_id', request()->endorser_id)->where('activity_type', request()->activity_type)->where('activity_id', request()->activity_id)->first();
        $endorsement->delete();

        return response()->noContent();
    }
}
