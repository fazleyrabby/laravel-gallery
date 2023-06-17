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
        $this->publishes([
            __DIR__ . '/config/gallery.php' => config_path('gallery.php'),
        ], 'gallery');
    }
}
