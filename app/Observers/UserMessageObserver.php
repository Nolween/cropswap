<?php

namespace App\Observers;

use App\Events\UserMessageCreatedEvent;
use App\Models\UserMessage;

class UserMessageObserver
{
    /**
     * Handle the UserMessage "created" event.
     */
    public function created(UserMessage $userMessage): void
    {
        // Fire the UserMessageCreatedEvent
        UserMessageCreatedEvent::dispatch($userMessage);
    }

    /**
     * Handle the UserMessage "updated" event.
     */
    public function updated(UserMessage $userMessage): void
    {
        //
    }

    /**
     * Handle the UserMessage "deleted" event.
     */
    public function deleted(UserMessage $userMessage): void
    {
        //
    }

    /**
     * Handle the UserMessage "restored" event.
     */
    public function restored(UserMessage $userMessage): void
    {
        //
    }

    /**
     * Handle the UserMessage "force deleted" event.
     */
    public function forceDeleted(UserMessage $userMessage): void
    {
        //
    }
}
