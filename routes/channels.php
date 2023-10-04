<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });

// only for private channel (chat)
Broadcast::channel('chat-{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// typingevent channel for showing who is typing
Broadcast::channel('typingevent', function($user) {
    return Auth::check();
});

// user-status channel for showing online and offline users
Broadcast::channel('user-status', function($user) {
    return $user;
});
