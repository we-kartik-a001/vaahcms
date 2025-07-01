<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use VaahCms\Modules\OrderSystem\Mails\orderstatusMail;

class OrderSendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function handle(): void
    {
        if ($this->order->customer && $this->order->customer->email) {
            dd($this->order->customer);
            Mail::to($this->order->customer->email)
                ->send(new orderstatusMail($this->order));
        }
    }
}
