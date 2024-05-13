<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCropRequest;
use App\Http\Requests\UpdateCropRequest;
use App\Models\Crop;
use App\Models\Swap;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CropController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function adminIndex()
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
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get Crops with only id, name, and user_id as userId and user name as user
        $crops = Crop::with('swaps:id')
                     ->orderBy('name')
                     ->get();


        $crops = $crops->map(function ($crop) {
            // Check the highest quantity value of swaps for this crop
            $maxQuantity = $crop->swaps->max('quantity');


            return [
                'id'          => $crop->id,
                'icon'        => $maxQuantity === 2 ? 'leaf-green' : ($maxQuantity === 1 ? 'leaf-orange' : 'leaf-red'),
                'position'    => [(float)$crop->latitude, (float)$crop->longitude],
                'swaps'       => $crop->swaps,
                'name'        => $crop->name,
                'description' => $crop->description,
            ];
        });


        return Inertia::render(
            'Crop/Index',
            [
                'markers' => $crops,
                'swaps'   => Swap::all(),
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
