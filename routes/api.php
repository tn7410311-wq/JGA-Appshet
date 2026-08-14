<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();

    // Forward request to Laravel's public/index.php
    require __DIR__ . '/../public/index.php';
})->middleware('auth:sanctum');
