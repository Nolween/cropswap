<?php

use App\Models\BlogArticle;
use App\Models\Crop;
use App\Models\CropSwap;
use App\Models\Swap;
use App\Models\User;
use App\Models\UserMessage;
use Inertia\Testing\AssertableInertia;
use function Pest\Laravel\get;
use function Pest\Laravel\actingAs;
use App\Http\Controllers\AdminDashboardController;

beforeEach(function () {
    // Create an admin user
    $this->adminUser = User::factory()->create(['role' => 'admin']);
    Crop::factory()->create(['user_id' => $this->adminUser->id]);

    // Create a normal user
    $normalUser = User::factory()->create(['role' => 'user']);
    $this->normalUser = $normalUser;
    Crop::factory()->create(['user_id' => $normalUser->id]);

    // Create 10 others users and crops for all users
    User::factory(10)->create()->each(function ($user) {
        Crop::factory()->create(['user_id' => $user->id]);
    });

    // Create swaps
    Swap::factory(rand(50, 100))->create();
    $this->swapCount = Swap::count();

    // For each Crop, assign random swaps
    $this->crops = Crop::factory(rand(10, 50))->create();

    generateCropSwaps();

    $this->cropCount = Crop::count();

    // Generate random messages for the users
    UserMessage::factory(rand(10, 50))->create();
    $this->messagesCount = UserMessage::count();

    // Create Random blog articles
    BlogArticle::factory(rand(1, 10))->create();
    $this->articlesCount = BlogArticle::count();
});

test('get dashboard stats', function () {
    $response = actingAs($this->adminUser)->get(action([AdminDashboardController::class, 'index']));

    $response->assertInertia(function (AssertableInertia $page) {
        $page->component('Admin/Dashboard');
        $page->has('cropsCount');
        $page->where('cropsCount', $this->cropCount);
        $page->has('messagesCount');
        $page->where('messagesCount', $this->messagesCount);
        $page->has('swapsCount');
        $page->where('swapsCount', $this->swapCount);
        $page->has('articlesCount');
        $page->where('articlesCount', $this->articlesCount);
    });
});

test('normal user cannot access the dashboard', function () {
    actingAs($this->normalUser)->get(action([AdminDashboardController::class, 'index']))->assertRedirect();
});


