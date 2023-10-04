<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Alumni;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Notifications\CreateNewFundEventNotification;
use App\Notifications\CreateNewPostNotification;
use App\Notifications\FriendRequestNotification;
use App\Notifications\ProfileCompletionNotification;
use App\Notifications\FriendRequestAcceptNotification;

class NotificationController extends Controller
{
    public function getUnreadNotification()
    {
        $alumni = Alumni::findOrFail(request()->auth_id);

        return NotificationResource::collection($alumni->unreadNotifications);
    }

    public function readNotification() {
        $alumni = Alumni::findOrFail(request()->alumni_id);

        $userUnreadNotification = $alumni->unreadNotifications
        ->where('id', request()->notification_id)
        ->first();

        if ($userUnreadNotification) {
            $userUnreadNotification->markAsRead();
        }

        return response()->json([
            'status' => 'success',
            'redirect_url' => $userUnreadNotification->data['redirect_rul']
        ]);
    }

    public function profileCompletionNotification($receiver_id)
    {
        $sender = Alumni::find(request()->sender_id);
        $sender_name = $sender->first_name;
        $alumni = Alumni::findOrFail($receiver_id);
        $alumni->notify(new ProfileCompletionNotification(request()->redirect_url, request()->sender_id, $sender_name, request()->profile_completion_percentage_amount));

        return response()->noContent();
    }

    public function friendRequestNotification($receiver_id) {
        $sender = Alumni::find(request()->sender_id);
        $sender_name = $sender->first_name;
        $alumni = Alumni::findOrFail($receiver_id);
        $alumni->notify(new FriendRequestNotification(request()->redirect_url, request()->sender_id, $sender_name));

        return response()->noContent();
    }

    public function friendRequestAcceptNotification($receiver_id)
    {
        $sender = Alumni::find(request()->sender_id);
        $sender_name = $sender->first_name;
        $alumni = Alumni::findOrFail($receiver_id);
        $alumni->notify(new FriendRequestAcceptNotification(request()->redirect_url, request()->sender_id, $sender_name));

        return response()->noContent();
    }

    public function createNewPostNotification() {
        $sender = Alumni::find(request()->sender_id);
        $sender_name = $sender->first_name;
        $alumnus = Alumni::whereNot('id', request()->sender_id)->where('status', 'Active')->get();

        foreach ($alumnus as $alumni) {
            $alumni->notify(new CreateNewPostNotification(request()->redirect_url, request()->sender_id, $sender_name));
        }

        return response()->noContent();
    }

    public function createNewFundEventNotification()
    {

        $sender = User::find(request()->sender_id);
        $sender_name = $sender->name;
        $alumnus = Alumni::whereNot('user_id', request()->sender_id)->where('status', 'Active')->get();

        foreach ($alumnus as $alumni) {
            $alumni->notify(new CreateNewFundEventNotification(request()->redirect_url, request()->sender_id, $sender_name, request()->amount));
        }

        return response()->noContent();
    }
}
