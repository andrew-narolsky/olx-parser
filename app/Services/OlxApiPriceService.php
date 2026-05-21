<?php

namespace App\Services;

use App\Contracts\PriceServiceInterface;

class OlxApiPriceService implements PriceServiceInterface
{
    private const string API_BASE = 'https://www.olx.ua/api/v1/offers/';

    public function getPrice(string $url): ?float
    {
        // Here we can implement the logic to fetch the price from the OLX API
    }
}
