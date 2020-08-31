<?php

namespace Guizoxxv\LaravelMultiSizeImage;

use Illuminate\Support\ServiceProvider;

class MultiSizeImageServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/multiSizeImage.php', 'multiSizeImage'
        );
    }

}