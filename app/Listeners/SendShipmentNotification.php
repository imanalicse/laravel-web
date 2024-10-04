<?php

namespace App\Listeners;

use App\Events\OrderShipped;
use DateTime;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Throwable;

class SendShipmentNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * The number of times the queued listener may be attempted.
     *
     * @var int
     */
    public $tries = 5;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderShipped $event): void
    {
        //
        Log::debug('send_shipment_notification called');
        $release = false;
        if ($release) {
            $this->release(30);
        }
    }

    public function failed(OrderShipped $event, Throwable $exception): void
    {
        // ...
    }

    /**
     * Determine the time at which the listener should timeout.
     */
    /*
    public function retryUntil(): DateTime
    {
        return now()->addMinutes(5);
    }
    */
}
