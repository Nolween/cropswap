<?php

use App\Models\Crop;
use App\Models\CropSwap;
use App\Models\Swap;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

uses(TestCase::class, RefreshDatabase::class)->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeJustOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function something()
{
    // ..
}

function generateCropSwaps(int $min = 1, int $max = 10)
{
    foreach (Crop::all() as $crop) {
        // Attach rand min to max swaps to the crop
        foreach (range(1, rand($min, $max)) as $i) {
            $swap = Swap::inRandomOrder()->first();
            $swapExists = CropSwap::where('crop_id', $crop->id)->where('swap_id', $swap->id)->exists();
            if ($swapExists) {
                continue;
            }
            $crop->swaps()->attach($swap->id, ['quantity' => CropSwap::QUANTITIES[array_rand(CropSwap::QUANTITIES)]]);
        }
    }
}

