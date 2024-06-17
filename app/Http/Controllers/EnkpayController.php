<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\PaymentRequest;
use App\Traits\Processor;

class EnkpayController extends Controller
{


    use Processor;

    private $config_values;

    private PaymentRequest $payment;
    private $user;

    public function __construct(PaymentRequest $payment, User $user)
    {
        $config = $this->payment_config('flutterwave', 'payment_config');
        if (!is_null($config) && $config->mode == 'live') {
            $this->config_values = json_decode($config->live_values);
        } elseif (!is_null($config) && $config->mode == 'test') {
            $this->config_values = json_decode($config->test_values);
        }
        $this->payment = $payment;
        $this->user = $user;
    }


    public function initialize(Request $request)
    {

    

        $data = $this->payment::where(['id' => $request['payment_id']])->where(['is_paid' => 0])->first();
        if (!isset($data)) {
            return response()->json($this->response_formatter(GATEWAYS_DEFAULT_204), 200);
        }

    

      
        $key = env('WEBKEY');
        $ref = BOOM();
        $email = Auth::user()->email;

        $url = "https://web.enkpay.com/pay?amount=$data->payment_amount&key=$key&ref=$ref&email=$email";


        $data = new Deposit();
        $data->user_id = Auth::id();
        $data->method_code = 102;
        $data->method_currency = "NGN";
        $data->amount = $request->amount;
        $data->charge = 0;
        $data->rate = 0;
        $data->final_amo = $request->amount;
        $data->btc_amo = 0;
        $data->btc_wallet = "";
        $data->trx = $ref;
        $data->status = 2;

        $data->save();

        $message = Auth::user()->email . "| wants to fund |  NGN " . number_format($request->amount) . " | with ref | $ref |  on ACEBOOSTSS";
        send_notification_2($message);


        return Redirect::to($url);
    }
}
