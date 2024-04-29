<?php

namespace App\Events;

use App\Models\UserMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserMessageCreatedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public UserMessage $userMessage;

    /**
     * Create a new event instance.
     */
    public function __construct(UserMessage $userMessage)
    {
        $this->userMessage = $userMessage;
    }


    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        // Broadcast on a private channel for the sender and receiver
        return [
            new PrivateChannel('messages.' . $this->userMessage->sender_id),
            new PrivateChannel('messages.' . $this->userMessage->receiver_id),
        ];
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith(): array
    {
        return [
            'user_message' => [
                'id'             => $this->userMessage->id,
                'sender_id'      => $this->userMessage->sender_id,
                'receiver_id'    => $this->userMessage->receiver_id,
                'content'        => $this->userMessage->content,
                'created_at'     => $this->userMessage->created_at,
                'sender_name'    => $this->userMessage->sender->name,
                'receiver_name'  => $this->userMessage->receiver->name,
                'sender_image'   => $this->userMessage->sender->image,
                'receiver_image' => $this->userMessage->receiver->image,
            ],
        ];
    }

}
