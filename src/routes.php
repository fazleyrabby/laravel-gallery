<?php

use Illuminate\Support\Facades\Route;
use Rabbi\LaravelGallery\LaravelGalleryController;

Route::get('gallery', [LaravelGalleryController::class, 'default']);

// Route::get('rgallery', [LaravelGalleryController::class, 'default']);