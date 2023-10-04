<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Message;
use App\Events\PublicChat;
use App\Events\PrivateChat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MessageController extends Controller
{
    public function userMessage($authUserId = null, $userId = null)
    {
        $user = User::with('alumni.alumni')->findOrFail($userId);
        $messages = $this->message_by_user_id($authUserId, $userId);
        return response()->json([
            'messages' => $messages,
            'user' => $user,
        ]);
    }


    public function sendMessage(Request $request)
    {
        $messages = Message::create([
            'message' => $request->message,
            'from' => $request->auth_user_id,
            'to' => $request->user_id,
            'type' => 0
        ]);

        $messages = Message::create([
            'message' => $request->message,
            'from' => $request->auth_user_id,
            'to' => $request->user_id,
            'type' => 1
        ]);

        // broadcast(new PublicChat($messages)); // for public channel
        broadcast(new PrivateChat($messages)); // for private channel

        return response()->json($messages, 201);
    }

    public function deleteSingleMessage($messageId = null)
    {
        Message::findOrFail($messageId)->delete();

        return response()->json('deleted', 200);
    }

    public function deleteAllMessage($authUserId = null, $userId = null)
    {
        $messages = $this->message_by_user_id($authUserId, $userId);
        foreach ($messages as $value) {
            Message::findOrFail($value->id)->delete();
        }

        return response()->json('all deleted', 200);
    }

    public function message_by_user_id($authUserId, $userId)
    {
        $messages = Message::where(function ($q) use ($authUserId, $userId) {
            $q->where('from', $authUserId);
            $q->where('to', $userId);
            $q->where('type', 0);
        })->orWhere(function ($q) use ($userId, $authUserId) {
            $q->where('from', $userId);
            $q->where('to', $authUserId);
            $q->where('type', 1);
        })->with('user', 'user.alumni.alumni')->get();

        return $messages;
    }
}
