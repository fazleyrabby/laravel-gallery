<?php

use Illuminate\Support\Facades\Route;
use Rabbi\LaravelGallery\LaravelGalleryController;

Route::get('/gallery/download/', [LaravelGalleryController::class, 'downloadImage'])->name('gallery.download');
Route::resource('gallery', LaravelGalleryController::class);
Route::post('/gallery/delete', [LaravelGalleryController::class, 'destroy'])->name('gallery.delete');
Route::post('/gallery/delete?type=all', [LaravelGalleryController::class, 'destroy'])->name('gallery.delete.all');

// Route::get('rgallery', [LaravelGalleryController::class, 'default']);