<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FundEventRequest;
use App\Http\Resources\FundEventCollection;
use App\Http\Resources\FundEventDetailsCollection;
use App\Interfaces\FundEventInterface;
use App\Models\FundEvent;
use App\Models\FundEventDetails;
use Illuminate\Http\Request;

class FundEventController extends Controller
{

    protected $fundEvent;

    public function __construct(FundEventInterface $fundEvent)
    {
        $this->fundEvent=$fundEvent;
    }


    public function index()
    {
        if (request()->per_page) {
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;

            $query = FundEvent::query()
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orderBy('id', 'asc')
                ->paginate($perPage);

            return new FundEventCollection($query);
        } else {
            $query = FundEvent::query()->where('status','Active')->get();

            return new FundEventCollection($query);
        }
    }

    public function fundEventDetails($fundEventId)
    {
        if (request()->per_page) {
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;

            $query = FundEventDetails::query()
                ->with('fundEvent','user')
                ->where('fund_event_id', $fundEventId)
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orderBy('id', 'asc')
                ->paginate($perPage);

            return new FundEventDetailsCollection($query);
        } else {
            $query = FundEventDetails::query()->with('fundEvent','user')->where('fund_event_id', $fundEventId)->get();

            return new FundEventDetailsCollection($query);
        }
    }

    public function getCreatorWise(){
        $query = FundEvent::query()->where('status','Active')->where('created_by',request()->user_id)->get();

        return new FundEventCollection($query);
    }

    public function deletedListIndex()
    {
        $fundEvent = $this->fundEvent->onlyTrashed();

        return response()->json($fundEvent);
    }

    public function store(FundEventRequest $request)
    {
        $fundEvent = $this->fundEvent->create($request);

        return response()->json($fundEvent);
    }

    public function show(FundEvent $fundEvent)
    {
        $fundEvent = FundEvent::query()->with('fundEventDetails','fundEventDetails.user')->findOrFail($fundEvent->id);

        return response()->json($fundEvent);
    }

    public function edit(FundEvent $fundEvent)
    {
        $fundEvent = $this->fundEvent->findOrFail($fundEvent->id);

        return response()->json($fundEvent);
    }

    public function update(FundEventRequest $request, FundEvent $fundEvent)
    {
        $fundEvent = $this->fundEvent->update($fundEvent->id,$request);

        return response()->json($fundEvent);
    }

    public function destroy(FundEvent $fundEvent)
    {
        $this->fundEvent->delete($fundEvent->id);
        return response()->json([
            'message' => trans('fundEvent.deleted'),
        ], 200);
    }

    public function restore($id)
    {
        $this->fundEvent->restore($id);
        return response()->json([
            'message' => trans('fundEvent.restored'),
        ], 200);
    }

    public function forceDelete($id)
    {
        $this->fundEvent->forceDelete($id);
        return response()->json([
            'message' => trans('fundEvent.permanent_deleted'),
        ], 200);
    }

    public function status(Request $request)
    {
        $this->fundEvent->status($request->id);
        return response()->json([
            'message' => trans('fundEvent.status_updated'),
        ], 200);
    }

    public function fundPayment(Request $request)
    {
        FundEventDetails::query()->create([
            'fund_event_id' => $request->id,
            'user_id' => $request->auth_id,
            'paid_amount' => $request->paid_amount,
        ]);
        return response()->json([
            'message' => 'Payment Success',
        ], 200);
    }


    /*public function show(FundEvent $fundEvent)
    {
        //
    }

    public function edit(FundEvent $fundEvent)
    {
        //
    }


    public function update(Request $request, FundEvent $fundEvent)
    {
        //
    }

    public function destroy(FundEvent $fundEvent)
    {
        //
    }*/
}
