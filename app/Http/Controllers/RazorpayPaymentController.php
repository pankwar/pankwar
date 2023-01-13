<?php

namespace App\Http\Controllers;

use Exception;

use Razorpay\Api\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RazorpayPaymentController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        return view('payment');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function payment(Request $request)
    {
        $input = $request->all();

        dd($input);

        $api = new Api("rzp_test_tbZbuQ2zbwgsaa", "hb7UhSP72F8Jx4zgUqsOP9If");

        $payment = $api->payment->fetch($input['razorpay_payment_id']);

        if(count($input)  && !empty($input['razorpay_payment_id'])) {
            try {
                $response = $api->payment->fetch($input['razorpay_payment_id'])
                            ->capture(array('amount'=>$payment['amount']));

                            // dd($response);
            } catch (Exception $e) {
                return  $e->getMessage();
                Session::put('error',$e->getMessage());
                return redirect()->back();
            }
        }
        // dd($response);

        Session::put('success', 'Payment successful');
        return redirect()->back();
    }
}
