<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{

    /**
     * Handle the UserMessage "deleted" event.
     */
    public function deleting(User $user): void
    {
        // Delete all user messages, crops
        $user->crop()->delete();
        $user->sentMessages()->delete();
        $user->receivedMessages()->delete();
    }
}
