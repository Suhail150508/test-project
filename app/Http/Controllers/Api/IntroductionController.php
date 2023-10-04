<?php

namespace App\Http\Controllers\Api;

use App\Models\Introduction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IntroductionController extends Controller
{
    public function introductionList() {
        $stepOneValue = Introduction::where('key', 'step_one')->first('value');
        $stepTwoValue = Introduction::where('key', 'step_two')->first('value');
        $stepThreeValue = Introduction::where('key', 'step_three')->first('value');

        return response()->json([
            'step_one' => $stepOneValue,
            'step_two' => $stepTwoValue,
            'step_three' => $stepThreeValue
        ]);
    }

    public function introductionStepOneUpdate(Request $request) {
        $this->validate($request, [
            'step_one' => 'required',
        ]);

        Introduction::updateOrCreate(['key' => 'step_one'], ['value' => $request->get('step_one')]);

        return response()->json([
            'message' => 'Data updated successfully'
        ]);
    }

    public function introductionStepTwoUpdate(Request $request) {
        $this->validate($request, [
            'step_two' => 'required',
        ]);

        Introduction::updateOrCreate(['key' => 'step_two'], ['value' => $request->get('step_two')]);

        return response()->json([
            'message' => 'Data updated successfully'
        ]);
    }

    public function introductionStepThreeUpdate(Request $request) {
        $this->validate($request, [
            'step_three' => 'required',
        ]);

        Introduction::updateOrCreate(['key' => 'step_three'], ['value' => $request->get('step_three')]);

        return response()->json([
            'message' => 'Data updated successfully'
        ]);
    }
}
