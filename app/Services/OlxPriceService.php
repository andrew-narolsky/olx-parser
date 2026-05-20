<?php

namespace App\Services;

use App\Contracts\PriceServiceInterface;
use App\Exceptions\OlxParsingException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\DomCrawler\Crawler;

class OlxPriceService implements PriceServiceInterface
{
    public function getPrice(string $url): ?float
    {
        try {
            $response = Http::timeout(15)
                ->retry(3, 1000)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0',
                ])
                ->get($url);

            if (!$response->successful()) {
                throw new OlxParsingException(
                    "OLX request failed: {$response->status()}"
                );
            }

            $crawler = new Crawler(
                $response->body()
            );

            $json = $crawler
                ->filter('script[type="application/ld+json"]')
                ->first()
                ->text();

            $data = json_decode($json, true);

            return isset($data['offers']['price'])
                ? (float)$data['offers']['price']
                : null;

        } catch (\Throwable $e) {

            Log::error('OLX parsing failed', [
                'url' => $url,
                'message' => $e->getMessage(),
            ]);

            throw $e;
        }
    }
}
