<?php

namespace App\Http\Controllers;

use App\Enums\SwapCategoryEnum;
use App\Http\Requests\StoreSwapRequest;
use App\Http\Requests\UpdateSwapRequest;
use App\Models\Swap;
use Inertia\Inertia;

class SwapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $swaps = Swap::select('id', 'name', 'image', 'category')
            ->orderBy('name')
            ->get();

        // Add an url prefix to the image
        $swaps->map(function ($swap) {
            $swap->image = asset('images/food/' . $swap->image);
            return $swap;
        });


        return Inertia::render(
            'Admin/Swap/Index',
            [
                'swaps' => $swaps,
                'categories' => SwapCategoryEnum::allTranslated(),
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
    public function store(StoreSwapRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Swap $swap)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Swap $swap)
    {
        //
    }
}
