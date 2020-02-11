<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Classes\Interfaces\ReadFileInterface;
use App\Classes\ParseXlsx;
use SimpleXLSX;

class CreateFormServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ReadFileInterface::class, function ($app) {
            return new ParseXlsx(new SimpleXLSX());
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
