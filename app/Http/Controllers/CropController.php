<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCropRequest;
use App\Http\Requests\UpdateCropRequest;
use App\Models\Crop;
use Inertia\Inertia;

class CropController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get Crops with only id, name, and user_id as userId and user name as user
        $crops = Crop::select('id', 'name', 'user_id', 'image')
                     ->orderBy('name')
                     ->get();

        $crops = $crops->map(function ($crop) {
            return [
                'id'      => $crop->id,
                'name'    => $crop->name,
                'image'   => $crop->image,
                'user'    => $crop->user->name,
                'reports' => 5, // Fake data
                'userId'  => $crop->user_id,
            ];
        });

        return Inertia::render(
            'Admin/Crop/Index',
            [
                'crops' => $crops,
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
    public function store(StoreCropRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Crop $crop)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Crop $crop)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCropRequest $request, Crop $crop)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Crop $crop)
    {
        //
    }
}
