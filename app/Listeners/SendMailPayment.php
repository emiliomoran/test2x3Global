<?php

namespace App\Listeners;

use App\Events\SendMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Client;
use Illuminate\Support\Facades\Mail;

class SendMailPayment
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SendMail  $event
     * @return void
     */
    public function handle(SendMail $event)
    {
        $client = Client::find($event->userId)->toArray();

        //Sending email with configuration in .env file and sending to email associtated with the client
        Mail::send('email', ['client' => $client], function ($message) use ($client) {
            $message->subject('Payment!');
            $message->to($client['email']);
        });
    }
}
