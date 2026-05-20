<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PriceChangedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $url,
        public ?float $oldPrice,
        public float  $newPrice
    )
    {
    }

    public function build(): PriceChangedMail
    {
        return $this->subject('OLX price changed')
            ->view('emails.price-changed');
    }
}
