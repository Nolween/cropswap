<?php

namespace App\Http\Controllers;

use App\Events\TestEvent;
use App\Http\Requests\StoreUserMessageRequest;
use App\Http\Requests\UpdateUserMessageRequest;
use App\Models\UserMessage;
use Inertia\Inertia;

class UserMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all messages with the user in sender or receiver, ordered by created_at
        $messages = UserMessage::where('sender_id', auth()->id())
                               ->orWhere('receiver_id', auth()->id())
                               ->with('sender', 'receiver')
                               ->orderBy('created_at', 'desc')
                               ->get();

        $authId = auth()->id();

        // Group messages by user
        $conversations = $messages->groupBy(function ($message) use ($authId) {
            return $message->sender_id === $authId ? $message->receiver_id : $message->sender_id;
        });

        // Reorganize the conversations
        $finalConversations = $conversations->map(function ($conversation) {
            $otherUser = $conversation->first()->sender_id === auth()->id() ? $conversation->first(
            )->receiver : $conversation->first()->sender;
            // If $otherUser->image is an URL, use it, otherwise use a default image
            $userImage = filter_var(
                $otherUser->image,
                FILTER_VALIDATE_URL
            ) ? $otherUser->image : '/images/user/' . $otherUser->image;
            //    return an object with name of the other user, the last message and the number of unread messages
            return (object)[
                'user'            => $otherUser->name,
                'receiver_id'     => $otherUser->id,
                'last_message'    => $conversation->first()->content,
                'messages'        => $conversation->all(),
                'unread'          => $conversation->where('receiver_id', auth()->id())->where('read_at', null)->count(),
                'user_image'      => $userImage,
                'conversation_id' => $conversation->first()->id,
            ];
        });

        return Inertia::render('Account/Messages', [
            'title'         => 'Messages Index',
            'conversations' => $finalConversations,
            'authId'        => $authId,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserMessageRequest $request)
    {
        $message = UserMessage::create($request->validated());

        return response()->json(['message' => 'Message envoyé', 'success' => true]);
    }

    /**
     * Display the specified resource.
     */
    public function show(UserMessage $userMessage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserMessage $userMessage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserMessageRequest $request, UserMessage $userMessage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserMessage $userMessage)
    {
        //
    }
}
