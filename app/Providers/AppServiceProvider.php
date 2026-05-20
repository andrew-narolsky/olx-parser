<?php

namespace App\Providers;

use App\Contracts\PriceServiceInterface;
use App\Services\OlxPriceService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(PriceServiceInterface::class, OlxPriceService::class);
    }

    public function boot(): void
    {

    }
}
