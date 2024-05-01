<?php

namespace App\Repositories\Interfaces;

use App\Models\BlogArticle;

interface BlogArticleRepositoryInterface
{
    public function index(?string $tag = null);
    public function adminIndex();
    public function create();
    public function store();
    public function show();
    public function edit(BlogArticle $blogArticle);
    public function update();
    public function destroy();
}
