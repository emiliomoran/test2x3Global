<?php

namespace App\Http\Controllers\Api;

use App\Events\SendMail;
use App\Payment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Jobs\ProcessPayment;
use DateTime;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Taking param from request
        try {
            $client_id = $request->client;

            if ($client_id) {
                //If exists the client_id param, then filter by its
                return Payment::where("user_id", "=", $client_id)->get();
            } else {
                //If not exists, get all
                return Payment::all();
            }
        } catch (\Throwable $th) {
            return response()->json(['message' => "Server error"], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $payment = new Payment($request->all());
            $payment->uuid = (string) Str::uuid();
            $payment->save();
            event(new SendMail($payment->fresh()->toArray()['user_id']));
            ProcessPayment::dispatch($payment->fresh());

            return response()->json(['data' => $payment->fresh()->toArray()], 201);
        } catch (\Throwable $th) {
            return response()->json(['message' => "Server error"], 500);
        }
    }

    /**
     * Update a resource with status pending in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function pay(Request $request)
    {
        try {
            $uuid = $request->get("uuid");
            $payment = Payment::where('uuid', '=', $uuid)->first();
            $payment_date = new DateTime();
            $payment->payment_date = $payment_date;
            $payment->status = "paid";

            $payment->save();

            return response()->json(['data' => $payment->fresh()->toArray()], 201);
        } catch (\Throwable $th) {
            return response()->json(['message' => "Server error"], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
