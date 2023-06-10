<?php

namespace Rabbi\LaravelGallery;

use Illuminate\Support\ServiceProvider;

class LaravelGalleryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('Rabbi\LaravelGallery\LaravelGalleryController');
        $this->loadViewsFrom(__DIR__.'/views','laravel-gallery');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        include __DIR__ . '/routes.php';
    }
}
