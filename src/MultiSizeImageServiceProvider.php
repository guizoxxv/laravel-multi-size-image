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
        $this->publishes([
            __DIR__ . '/../config/multiSizeImage.php' => config_path('multiSizeImage.php'),
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

}