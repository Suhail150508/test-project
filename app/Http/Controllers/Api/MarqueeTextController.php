<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MarqueeCollection;
use Illuminate\Http\Request;
use App\Models\MarqueeText;

class MarqueeTextController extends Controller
{
    public function getMarqueeTexts() {
        if (request()->per_page) {
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;

            $query = MarqueeText::query()
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orderBy('id', 'asc')
                ->paginate($perPage);

            return new MarqueeCollection($query);
        } else {
            $query = MarqueeText::where('status', 'Active')->get();

            return new MarqueeCollection($query);
        }
    }

    public function storeMarqueeText(Request $request) {
        $marqueeTextData = $request->all();
        $marqueeText = MarqueeText::create($marqueeTextData);

        return response()->json($marqueeText, 201);
    }

    public function updateMarqueeText(Request $request, $id)
    {
        $marqueeTextData = $request->all();
        $marqueeText = MarqueeText::find($id);

        if (!$marqueeText) {
            return response()->json(['message' => 'MarqueeText not found'], 404);
        }
        $marqueeText->update($marqueeTextData);

        return response()->json($marqueeText, 200);
    }

    public function deleteMarqueeText($id)
    {
        $marqueeText = MarqueeText::find($id);

        if (!$marqueeText) {
            return response()->json(['message' => 'MarqueeText not found'], 404);
        }

        $marqueeText->delete();

        return response()->json(['message' => 'MarqueeText deleted successfully'], 200);
    }

    // public function updateOrCreate(Request $request){
    //     foreach($request->marqueeTextFormDetails as $item) {
    //         MarqueeText::updateOrCreate([
    //             "title"=>$item['title'],
    //             "url"=>$item['url'],
    //         ]);
    //     }
    // }
}
