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

Broadcast::channel('private-notifications.{userId}', function ($user, $userId) {
    return true;
});

Broadcast::channel('presence-chat.{chatId}', function ($user, $chatId) {
    return [
        'id' => $user->id,
        'name' => $user->name,
    ]; // Returns user info to other users in the chat
});

Broadcast::channel('private.chat.{id}', function ($user, $chatId) {
    return true;
});
