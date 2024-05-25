<?php

namespace App\Http\Controllers;

use App\Enums\SwapCategoryEnum;
use App\Http\Requests\StoreSwapRequest;
use App\Http\Requests\UpdateSwapRequest;
use App\Models\Swap;
use Illuminate\Support\Str;
use Inertia\Inertia;

class SwapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function adminIndex()
    {
        $swaps = Swap::select('id', 'name', 'image', 'category')
                     ->orderBy('name')
                     ->get();

        // Add an url prefix to the image
        $swaps->map(function ($swap) {
            $swap->image = str_starts_with($swap->image, 'http') ? $swap->image : asset('images/food/' . $swap->image);
            return $swap;
        });

        return Inertia::render(
            'Admin/Swap/Index',
            [
                'swaps'      => $swaps,
                'categories' => SwapCategoryEnum::allTranslated(),
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render(
            'Admin/Swap/Create',
            [
                'swap'       => [
                    'category' => 'vegetable',
                    'name'     => '',
                    'image'    => 'empty.svg',
                    'id'       => null,
                ],
                'categories' => SwapCategoryEnum::allTranslated(),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSwapRequest $request)
    {
        // Moving the image to the right folder
        if ($request->hasFile('imageFile')) {
            $image = $request->file('imageFile');
            $imageName = Str::snake($request->get('name')) . '.' . $image->extension();
            // Move the image to the right folder
            $image->move(public_path('images/food'), $imageName);

            // Update the request with the new image name
            $request->merge(['image' => $imageName]);
            // dd($request->all());
        }

        //  Store Swap
        Swap::create($request->all());

        return response()->json(['success' => true]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Swap $swap)
    {
        //    Get Swap informations

        return Inertia::render('Admin/Swap/Create', [
            'swap'       => $swap,
            'categories' => SwapCategoryEnum::allTranslated(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Swap $swap)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSwapRequest $request, Swap $swap)
    {
        // Moving the image to the right folder
        if ($request->hasFile('imageFile')) {
            $image = $request->file('imageFile');
            $imageName = Str::snake($request->get('name')) . '.' . $image->extension();
            // Move the image to the right folder
            $image->move(public_path('images/food'), $imageName);

            // Update the request with the new image name
            $request->merge(['image' => $imageName]);

            // Delete the old image
            if ($swap->image !== 'empty.svg' && file_exists(public_path('images/food/' . $swap->image))) {
                unlink(public_path('images/food/' . $swap->image));
            }
        }

        $swap->update($request->all());

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Swap $swap)
    {
        // Delete the image
        if ($swap->image !== 'empty.svg') {
            unlink(public_path('images/food/' . $swap->image));
        }

        $swap->delete();

        return response()->json(['success' => true]);
    }
}
