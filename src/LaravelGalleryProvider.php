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
        // $this->mergeConfigFrom(
        //     __DIR__ . '/Config/config.php', 'gallery'
        // );
        $this->app->make('Rabbi\LaravelGallery\LaravelGalleryController');
        $this->loadViewsFrom(__DIR__.'/views','laravel-gallery');
        // config([
        //     'config/gallery.php',
        // ]);
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
