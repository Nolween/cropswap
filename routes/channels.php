<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('messages.{id}', function (User $user, $id) {
    return (int) $user->id === (int) $id;
});
Broadcast::channel('test', function () {
    return true;
});
