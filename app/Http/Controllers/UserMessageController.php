<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserMessageRequest;
use App\Http\Requests\UpdateUserMessageRequest;
use App\Models\UserMessage;

class UserMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
