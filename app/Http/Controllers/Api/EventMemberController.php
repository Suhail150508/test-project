<?php

namespace App\Http\Controllers\Api;

use App\Models\Event;
use App\Models\EventMember;
use Illuminate\Http\Request;
use App\Interfaces\EventInterface;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use Illuminate\Console\Scheduling\EventMutex;

class EventMemberController extends Controller
{
    protected $event;

    public function __construct(EventInterface $event)
    {
        $this->event = $event;
    }

    public function eventSuggestionList()
    {
        try {
            DB::beginTransaction();
            $interestedEventIds = EventMember::where('alumni_id', request()->auth_id)->where('status', 'interested')->pluck('event_id')->toArray();

            $goingEventIds = EventMember::where('alumni_id', request()->auth_id)->where('status', 'going')->pluck('event_id')->toArray();

            $interestedAndGoingEventIds = array_merge($interestedEventIds, $goingEventIds);

            $events = Event::with(['eventMembers', 'eventMembers.alumni'])->whereNot('user_id', request()->auth_id)->whereNotIn('id', $interestedAndGoingEventIds)->get();
            DB::commit();

            return EventResource::collection($events);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }

    public function getInterestedEvent() {
        $eventIds = EventMember::where('alumni_id', request()->user_id)->where('status', 'interested')->pluck('event_id')->toArray();
        $events = Event::whereIn('id', $eventIds)->get();
        // $eventSpeakers = Alumni::whereIn('id', json_decode($event->speakers))->get();
        // $event['eventSpeakers'] = $eventSpeakers;

        return EventResource::collection($events);
    }

    public function getGoingEvent() {
        $eventIds = EventMember::where('alumni_id', request()->user_id)->where('status', 'going')->pluck('event_id')->toArray();
        $events = Event::whereIn('id', $eventIds)->get();

        return EventResource::collection($events);
    }

    public function eventInterested($event_id) {
        try {
            $eventMember = new EventMember();
            $eventMember->event_id = $event_id;
            $eventMember->alumni_id = request()->auth_id;
            $eventMember->status = 'interested';
            $eventMember->save();

            return response()->json([
                'data' => $eventMember,
                'message' => 'Successfully interested add this event',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }

    public function eventNotInterested($event_id) {
        try {
            $eventNotInterested = EventMember::where('event_id', $event_id)->where('alumni_id', request()->auth_id)->where('status', 'interested')->first()->delete();

            return response()->json([
                'data' => $eventNotInterested,
                'message' => 'Successfully not interested add this event',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }

    public function eventGoing($event_id) {
        try {
            $eventGoing = EventMember::where('event_id', $event_id)->where('alumni_id', request()->auth_id)->where('status', 'interested')->first();
            $eventGoing->update([
                'status' => 'going',
            ]);

            return response()->json([
                'data' => $eventGoing,
                'message' => 'Successfully going add this event',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }

    public function eventNotGoing($event_id) {
        try {
            $eventNotGoing = EventMember::where('event_id', $event_id)->where('alumni_id', request()->auth_id)->where('status', 'going')->first()->delete();

            return response()->json([
                'data' => $eventNotGoing,
                'message' => 'Successfully not going add this event',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }
}
