<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use VK\Client\VKApiClient;

class AppServiceProvider extends ServiceProvider
{
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
        $this->app->singleton(VKApiClient::class, function () {
            $vk = new VKApiClient();
            return $vk;
        });
    }
}
