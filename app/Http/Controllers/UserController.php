<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all users
        $users = User::select('id', 'image', 'name', 'email', 'role')->get();
        return Inertia::render(
            'Admin/User/Index',
            [
                'title' => 'Admin User Index',
                'users' => $users,
            ]
        );
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {


        return Inertia::render(
            'Admin/User/Show',
            [
                'title' => 'Admin User Show',
                'user' => $user,
                'reportedMessages' => $user->reportedMessages,
                'crop' => $user->crop,
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['success' => true]);
    }
}
