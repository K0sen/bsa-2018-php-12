<?php

namespace App\Providers;

use App\Http\Controllers\JsonRpcController;
use App\Repository\CurrencyRepository;
use App\Service\CurrencyService;
use Illuminate\Support\ServiceProvider;

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
        app()->bind(CurrencyRepository::class, CurrencyRepository::class);
        app()->bind(CurrencyService::class, function () {
            return new CurrencyService(app(CurrencyRepository::class));
        });
        app()->bind(JsonRpcController::class, function () {
            return new JsonRpcController(app(CurrencyService::class));
        });
    }
}
