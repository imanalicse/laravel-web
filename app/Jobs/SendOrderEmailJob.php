<?php

namespace App\Jobs;

use App\Mail\OrderCreated;
use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\Attributes\Backoff;
use Illuminate\Queue\Attributes\FailOnTimeout;
use Illuminate\Queue\Attributes\Timeout;
use Illuminate\Queue\Attributes\Tries;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

#[Tries(3)]
#[Timeout(60)]
#[Backoff(10, 30)]
#[FailOnTimeout]
class SendOrderEmailJob implements ShouldQueue
{
    use Queueable;

    public function __construct(public Order $order)
    {
    }

    public function handle(): void
    {
        $customer = $this->order->customer;
        if (!$customer || empty($customer->email)) {
            Log::warning("SendOrderEmailJob: No customer email for order #{$this->order->id}");
            return;
        }

        Mail::to($customer->email)->send(new OrderCreated($this->order));

        $this->order->update(['is_email_sent' => 1]);

        Log::info("SendOrderEmailJob: Order confirmation sent for order #{$this->order->id} to {$customer->email}");
    }
}
