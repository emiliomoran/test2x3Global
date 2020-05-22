<?php

namespace App\Jobs;

use App\Payment;
use DateTime;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use GuzzleHttp\Client;

class ProcessPayment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $payment;

    public function __construct($payment)
    {
        $this->payment = $payment;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $today = (new DateTime())->format('Y-m-d');
        //$today = "2020-05-18";
        $paymentRecorded = Payment::where("created_at", "=", $today)->where("id", "!=", $this->payment->id)->whereNotNull("clp_usd")->first();
        if ($paymentRecorded) {
            dump("Exists");
            //Exists, then take clp_usd saved
            $this->payment->clp_usd = $paymentRecorded->clp_usd;
        } else {
            //Not exists, then take from API                        

            $client = new Client();
            $data = json_decode($client->get("https://mindicador.cl/api/dolar")->getBody());
            $serie = $data->serie;

            for ($i = 0; $i < sizeof($serie); $i++) {
                $date = date('Y-m-d', strtotime($serie[$i]->fecha));
                if ($today == $date) {
                    //If exists a register of today and get the value
                    $clp_usd = $serie[$i]->valor;
                    $this->payment->clp_usd = $clp_usd;
                    $this->payment->save();
                }
            }
        }
    }
}
