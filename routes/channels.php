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

// Private channel for individual users (students)
Broadcast::channel('user.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Admin dashboard channel - only accessible by admin users
Broadcast::channel('admin-dashboard', function ($user) {
    return $user->role === 'admin' || $user->role === 'guru';
});

// Presence channel for tracking online admins (optional)
Broadcast::channel('admins.online', function ($user) {
    if ($user->role === 'admin') {
        return ['id' => $user->id, 'name' => $user->name];
    }
    return false;
});
