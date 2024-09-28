<?php

namespace App\Http\Controllers;

use App\Mail\OrderCreated;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
# use SendGrid\Mail\Mail;

class MailController extends Controller
{
    public function sendTestEmail()
    {
        $response = Mail::raw('This is a test email', function ($message) {
            $message->to('imanali.cse@gmail.com')
                ->subject('Test Email from Laravel 11 via SendGrid');
        });
        echo '<pre>';
        print_r($response);
        echo '</pre>';
//        $order_id = 26;
//        $order = Order::find($order_id);
//
//       $email_response = Mail::to('imanali.cse@gmail.com')->send(new OrderCreated($order));
//       echo '<pre>';
//       print_r($email_response);
//       echo '</pre>';

//        $email = new \SendGrid\Mail\Mail();
//        $email->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
//        $email->setSubject('Test Email via SendGrid API');
//        $email->addTo('imanali.cse@gmail.com', 'Recipient Name');
//        $email->addContent('text/plain', 'This is a test email sent using SendGrid API.');
//
//        try {
//            $sendgrid = app('sendgrid.mailer');
//            $response = $sendgrid->send($email);
//
//            // Check for successful response
//            if ($response->statusCode() == 202) {
//                return response()->json(['message' => 'Email sent successfully!'], 200);
//            } else {
//                return response()->json(['message' => 'Failed to send email'], 500);
//            }
//        } catch (Exception $e) {
//            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
//        }

    }
}
