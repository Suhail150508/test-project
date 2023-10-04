<?php


namespace App\Repositories;

use App\Interfaces\EventInterface;
use App\Models\Event;

class EventRepository extends BaseRepository implements EventInterface
{
    public function __construct(Event $event)
    {
        $this->model = $event;
    }
}
