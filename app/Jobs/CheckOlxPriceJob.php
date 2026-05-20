<?php

namespace App\Jobs;

use App\Contracts\PriceServiceInterface;
use App\Mail\PriceChangedMail;
use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class CheckOlxPriceJob implements ShouldQueue
{
    use Dispatchable, Queueable, InteractsWithQueue;

    public function __construct(
        public string $url
    )
    {
    }

    public function handle(PriceServiceInterface $service): void
    {
        $newPrice = $service->getPrice($this->url);

        $subscriptions = Subscription::with('user')
            ->where('url', $this->url)
            ->get();

        foreach ($subscriptions as $sub) {

            if ($sub->last_price !== null &&
                $sub->last_price != $newPrice) {

                Mail::to($sub->user->email)
                    ->send(new PriceChangedMail(
                        $this->url,
                        $sub->last_price,
                        $newPrice
                    ));
            }

            $sub->update([
                'last_price' => $newPrice
            ]);
        }
    }
}
