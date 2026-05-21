<?php

namespace App\Providers;

use App\Contracts\PriceServiceInterface;
use App\Services\OlxApiPriceService;
use App\Services\OlxPriceService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(PriceServiceInterface::class, OlxPriceService::class);
//        $this->app->bind(PriceServiceInterface::class, OlxApiPriceService::class);
    }

    public function boot(): void
    {

    }
}
