<?php

namespace App\Repositories\Interfaces;

interface BlogArticleRepositoryInterface
{
    public function index();
    public function adminIndex();
    public function create();
    public function store();
    public function show();
    public function edit();
    public function update();
    public function destroy();
}
