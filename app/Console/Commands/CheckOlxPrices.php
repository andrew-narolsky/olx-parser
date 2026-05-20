<?php

namespace App\Console\Commands;

use App\Jobs\DispatchOlxChecksJob;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:check-olx-prices')]
#[Description('Manually trigger OLX price checking')]
class CheckOlxPrices extends Command
{
    public function handle(): int
    {
        DispatchOlxChecksJob::dispatch();

        $this->info('OLX price check dispatched successfully.');

        return self::SUCCESS;
    }
}
