<?php

namespace App\Http\Controllers;

use App\Models\BlogArticle;
use App\Models\Crop;
use App\Models\Swap;
use App\Models\UserMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AdminDashboardController extends Controller
{

    public function index()
    {
        // Get the crops count
        $cropsCount = Crop::count();
        // Get the number of messages
        $messagesCount = UserMessage::count();
        // Get the number of swaps
        $swapsCount = Swap::count();
        // Get the articles count
        $articlesCount = BlogArticle::count();

        return Inertia::render(
            'Admin/Dashboard',
            [
                'cropsCount' => $cropsCount,
                'messagesCount' => $messagesCount,
                'swapsCount' => $swapsCount,
                'articlesCount' => $articlesCount,
            ]
        );
    }
}
