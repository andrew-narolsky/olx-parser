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
        $urls = Subscription::query()
            ->select('subscriptions.url')
            ->join('users', 'users.id', '=', 'subscriptions.user_id')
            ->whereNotNull('users.email_verified_at')
            ->distinct()
            ->pluck('url');

        if ($urls->isEmpty()) {
            return;
        }

        $urls->each(fn($url) => CheckOlxPriceJob::dispatch($url));
    }
}
