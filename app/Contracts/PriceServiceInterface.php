<?php

namespace App\Contracts;

interface PriceServiceInterface
{
    public function getPrice(string $url): ?float;
}