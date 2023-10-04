<?php

namespace App\Http\Controllers\Api;

use App\Models\Event;
use App\Models\Alumni;
use Illuminate\Http\Request;
use App\Interfaces\EventInterface;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Models\EventMember;

class EventController extends Controller
{
    protected $event;

    public function __construct(EventInterface $event)
    {
        $this->event = $event;
    }

    public function index()
    {
        $events = Event::query()
            ->where('user_id', request()->user_id)
            ->where('user_type', request()->user_type)
            ->get();

        return EventResource::collection($events);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = $request;
            $data['speakers'] = json_encode($request->speakers);
            $parameters = [
                'image_info' => [
                    [
                        'type' => 'event-cover-photo',
                        'images' => $data->cover_image,
                        'directory' => 'event',
                        'input_field' => 'cover_image',
                        'width' => '',
                        'height' => '',
                    ]
                ],
            ];
            $event = $this->event->create($data, $parameters);
            DB::commit();

            return new EventResource($event);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }

    public function show(Event $event)
    {
        $event = $this->event->with(['alumni'])->findOrFail($event->id);
        $eventSpeakers = Alumni::whereIn('id', json_decode($event->speakers))->get();
        $event['eventSpeakers'] = $eventSpeakers;

        $interestedCount = EventMember::where('event_id', $event->id)->where('status', 'interested')->count();
        $goingCount = EventMember::where('event_id', $event->id)->where('status', 'going')->count();
        $event['interestedCount'] = $interestedCount;
        $event['goingCount'] = $goingCount;

        return new EventResource($event);
    }

    public function edit(Event $event)
    {

    }

    public function update(Request $request, Event $event)
    {
        try {
            DB::beginTransaction();
            $data = $request;
            $data['speakers'] = json_encode($request->speakers);
            $parameters = [
                'image_info' => [
                    [
                        'type' => 'event-cover-photo',
                        'images' => $data->cover_image,
                        'directory' => 'event',
                        'input_field' => 'cover_image',
                        'width' => '',
                        'height' => '',
                    ]
                ],
            ];
            $event = $this->event->update($event->id, $data, $parameters);
            $request['update'] = "update";
            DB::commit();

            return new EventResource($event);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }

    public function destroy(Event $event)
    {
        $event = $this->event->delete($event->id);
        return response()->noContent();
    }
}
