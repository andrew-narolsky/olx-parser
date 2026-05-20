<?php

namespace App\Jobs;

use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

class DispatchOlxChecksJob implements ShouldQueue
{
    use Dispatchable, Queueable, InteractsWithQueue;

    public function handle(): void
    {
        Subscription::query()
            ->select('url')
            ->distinct()
            ->pluck('url')
            ->each(function ($url) {
                CheckOlxPriceJob::dispatch($url);
            });
    }
}
