<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCropRequest;
use App\Http\Requests\UpdateCropRequest;
use App\Http\Requests\UpdateCropSwapRequest;
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
                // If $crop->image starts whit http, we keep it as is, else we add the path to the image
                'image'   => str_starts_with($crop->image, 'http') ? $crop->image : asset(
                    'images/crop/' . $crop->image
                ),
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
    public function show()
    {
        // Get the crop with the swaps
        $crop = Crop::with('swaps')->with('user')->where('user_id', Auth::user()->id)->first();

        $swapList = Swap::all();

        return Inertia::render(
            'Account/Crop',
            [
                'crop'     => $crop,
                'user'     => $crop->user,
                'swaps'    => $crop->swaps,
                'swapList' => $swapList,
            ]
        );
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
        // Moving the image to the right folder
        if ($request->hasFile('imageFile')) {
            $image = $request->file('imageFile');
            $imageName = $crop->id . '.' . $image->extension();
            // Move the image to the right folder
            $image->move(public_path('images/crop'), $imageName);

            // Update the request with the new image name
            $request->merge(['image' => $imageName]);
        } else {
            $request->merge(['image' => $crop->image]);
        }

        $crop->update($request->all());

        return response()->json(['success' => true]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function updateSwap(UpdateCropSwapRequest $request, Crop $crop)
    {

        if($request->quantity === null) {
            $crop->swaps()->detach($request->swapId);
            return response()->json(['success' => true]);
        }

        $pivot = $crop->swaps()->updateExistingPivot($request->swapId, ['quantity' => $request->quantity]);

        if ($pivot === 0) {
            $crop->swaps()->attach($request->swapId, ['quantity' => $request->quantity, 'created_at' => now(), 'updated_at' => now()]);
        }

        return response()->json(['success' => true]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Crop $crop)
    {
        //
    }
}
