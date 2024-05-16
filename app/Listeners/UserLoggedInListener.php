<?php

namespace App\Listeners;

use App\Events\UserLoggedInEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserLoggedInListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserLoggedInEvent $event): void
    {
        // Update the user's last login date
        $event->user->update(['last_connection_date' => now()]);
    }
}
