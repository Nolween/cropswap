<?php

namespace App\Http\Controllers;

use App\Models\BlogArticle;
use App\Models\Crop;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        // Get the 10 latest crop
        $crops = Crop::orderBy('created_at', 'desc')
                     ->take(10)
                     ->get();

        $crops = $crops->map(function ($crop) {
            return [
                'id'          => $crop->id,
                'icon'        => 'leaf-green',
                'position'    => [$crop->latitude, $crop->longitude],
                'name'        => $crop->user->name,
                'description' => $crop->description,
            ];
        });

        // Get Latest 5 Blog Articles
        $articles = BlogArticle::select('id', 'user_id', 'title', 'content', 'image', 'tags')->orderBy('created_at', 'desc')
                               ->with('user:id,name,image')
                               ->take(5)
                               ->get();


        return Inertia::render('Home', [
            'crops'    => $crops,
            'articles' => $articles,
        ]);
    }
}
