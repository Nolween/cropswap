<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function show()
    {
        $user = Auth::user();

        return Inertia::render(
            'Account/Informations',
            [
                'user'  => $user,
                'crops' => $user->crop,
            ]
        );
    }

    /**
     * Display the specified resource.
     */
    public function adminShow(User $user)
    {
        return Inertia::render(
            'Admin/User/Show',
            [
                'title'            => 'Admin User Show',
                'user'             => $user,
                'reportedMessages' => $user->reportedMessages,
                'crop'             => $user->crop,
                'admin_id'         => Auth::user()->id,
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
    public function update(UpdateUserRequest $request)
    {
        $user = Auth::user();

        // Moving the image to the right folder
        if ($request->hasFile('imageFile')) {
            $image = $request->file('imageFile');
            $imageName = $user->id . '.' . $image->extension();
            // Move the image to the right folder
            $image->move(public_path('images/user'), $imageName);
            // Remove old image
            unlink(public_path('images/user/' . $user->image));

            $user->image = $imageName;
        }
        if($request->has('newMail') && $request->newMail !== 'null' && $request->newMail !== $user->email){
            $user->email = $request->newMail;
        }
        if ($request->has('newPassword') && $request->newPassword !== 'null') {
            $user->password = bcrypt($request->newPassword);
        }
        if ($request->has('name') && $request->name !== $user->name) {
            $user->name = $request->name;
        }
        $update = $user->save();

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if(Auth::user()->id !== $user->id &&  Auth::user()->role !== 'admin'){
            return response()->json(['success' => false], 403);
        }

        $user->delete();

        // If User Auth is deleted, logout
        if(Auth::user()->id === $user->id){
            Auth::logout();
        }

        return response()->json(['success' => true]);
    }
}
