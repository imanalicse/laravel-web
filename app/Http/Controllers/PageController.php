<?php

namespace App\Http\Controllers;

use App\Events\OrderShipped;
use App\Jobs\SendEmailJob;
use App\Models\Order;

class PageController extends Controller
{
    public function home() {
        return view('page.home');
    }

    public function dispatchEvent($order_id): string
    {
        $order = Order::findOrFail($order_id);
        if (empty($order)) {
            return 'order not found';
        }
        OrderShipped::dispatch($order);
        return 'dispatch event';
    }

    public function dispatchJob(): string {
        $email_details = [
          'to_email'  => 'test@gmail.com'
        ];
        SendEmailJob::dispatch($email_details);
        return 'dispatch job';
    }
}
