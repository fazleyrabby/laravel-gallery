<?php

namespace Rabbi\LaravelGallery;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LaravelGalleryController extends Controller
{
    public function default()
    {
        return view('laravel-gallery::bs');
    }

    public function tailwind()
    {
        return view('laravel-gallery::tl');
    }
}
