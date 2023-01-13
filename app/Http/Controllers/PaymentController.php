<?php

namespace App\Http\Controllers;

use App\Mail\career;
use App\Models\SS_Job_Payment_Details;
use Razorpay\Api\Api;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{

    public function paymentInitiateRequest($req){

        // dd($req->career_data_id);
        $payment_status = (new SS_Job_Payment_Details)->checkAlreadyPaid($req->career_data_id);
        // dd($payment_status->payment_status);
        if(!empty($payment_status)){

        if($payment_status->payment_status == 1){
            return view('errors.already_paid');
        }

        }
         //generating random reciept id
        $receiptId = Str::random(20);
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        // creating order use capture
        $order = $api->order->create(array(
            'receipt' => $receiptId,
            // 'amount' => $req->all()['amount']*100,
            'amount' => "9900",
            // 'amount' => "100",
            'currency' => 'INR',
            // 'notes'=> array('key1'=> 'value3','key2'=> 'value2')
        )
    );
    //lets return the response
    //lets create the razorpay payment page
    $response = [
        'order_id' => $order['id'],
        'razorpayKey' => env('RAZORPAY_KEY'),
        // 'amount' => $req->all()['amount']*100,
        'amount' => "9900",
        'amount_in_rs' => "99",
        'full_name' => $req->full_name,
        'currency' => 'INR',
        'email' => $req->email,
        'contact' => $req->contact,
        // 'address' => $req->all()['address'],
        'description' => 'ONE TIME FEE (Lifetime)',
        'created_at' => $order['created_at'],
        'reciept_id' => $receiptId,
        'career_data_id' => $req->career_data_id,
        'ss_registration_code' => $req->ss_registration_code,
    ];
    return view('payment-page', compact('response'));

    }

    public function paymentComplete(Request $req){

    // Now verify the signature is correct . We create the private function for verify the signature
    $signatureStatus = $this->SignatureVerify(
        $req->all()['rzp_signature'],
        $req->all()['rzp_paymentid'],
        $req->all()['rzp_orderid']
    );
    // If Signature status is true We will save the payment response in our database
    // In this tutorial we send the response to Success page if payment successfully made
    if($signatureStatus == true)
    {
        $details = [
            'mail_type' => 'payment_success',
            'subject' => 'Success! - we have received the payment of Rs 99 (Ninty Nine Rupees) against order number ' .$req->all()['rzp_orderid'] . '!',
            'title' => "Payment Success Mail From Servesmile",

            'career_data_id' => $req->all()['career_data_id'],
            'full_name' => $req->all()['full_name'],
            'email' => $req->all()['email'],
            'contact' => $req->all()['contact'],
            'reciept_id' => $req->all()['reciept_id'],
            'amount_in_rs' => "99",
            'amount' => "9900",
            'description' => 'ONE TIME FEE (Lifetime)',
            'order_id' => $req->all()['rzp_orderid'],
            'created_at' => $req->all()['created_at'],
            'currency' => 'INR',
            'ss_registration_code' => $req->all()['ss_registration_code'],
            'rzp_signature' => $req->all()['rzp_signature'],
            'rzp_paymentid' => $req->all()['rzp_paymentid'],
            'payment_status' => "1",
            'error_code'=> '',
            'error_desccription'=> '',
            'error_source'=> '',
            'error_step'=> '',
            'error_reason'=> '',
            'error_metadata_order_id' => '',
            'error_metadata_payment_id'=> '',
        ];

        // You can create this page
        $data = (new SS_Job_Payment_Details)->addCareerPaymentDetails($details);

        // Mail::to($req->all()['email'])->cc('hr@servesmile.in')->bcc('servesmile21@gmail.com')->send(new career($details));
        Mail::to($req->all()['email'])->cc('servesmile21@gmail.com')->send(new career($details));


        $details2 = [
            'mail_type' => 'career_benefits',
            'subject' => 'We are glad to inform you regarding the benefits you are getting with us',
            'title' => "Congratulations for being life time candidate in Servesmile job portal",
        ];

        $detailsBenefits = array_merge($details,$details2);
        // ->cc('hr@servesmile.in')
        Mail::to($req->all()['email'])->cc('servesmile21@gmail.com')->send(new career($detailsBenefits));
        Mail::to($req->all()['email'])->cc('servesmile21@gmail.com')->send(new career($details));
        return view('payment-success-page');
    }
    else{
        $details = [
            'mail_type' => 'payment_failed',
            'subject' => 'Failed! - Payment of 99 Rs (Ninty Rupees) against order number ' .$req->all()['rzp_orderid'] . ' is failed !',
            'title' => "Payment Failed Mail From Servesmile",

            'career_data_id' => $req->all()['career_data_id'],
            'full_name' => $req->all()['full_name'],
            'email' => $req->all()['email'],
            'contact' => $req->all()['contact'],
            'reciept_id' => $req->all()['reciept_id'],
            'amount_in_rs' => "99",
            'amount' => "9900",
            'description' => 'ONE TIME FEE (Lifetime)',
            'order_id' => $req->all()['rzp_orderid'],
            'created_at' => $req->all()['created_at'],
            'currency' => 'INR',
            'ss_registration_code' => $req->all()['ss_registration_code'],
            'rzp_signature' => $req->all()['rzp_signature'],
            'rzp_paymentid' => $req->all()['rzp_paymentid'],
            'payment_status' => "0",
        ];
        // You can create this page
        $data = (new SS_Job_Payment_Details)->addCareerPaymentDetails($details);
        Mail::to($req->all()['email'])->cc('hr@servesmile.in')->bcc('servesmile21@gmail.com')->send(new career($details));
        // Mail::to($req->all()['email'])->cc('servesmile21@gmail.com')->send(new career($details));
        return view('payment-failed-page');
    }
    }

    // In this function we return boolean if signature is correct
private function SignatureVerify($_signature,$_paymentId,$_orderId)
{
    try
    {
        // Create an object of razorpay class
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $attributes  = array('razorpay_signature'  => $_signature,  'razorpay_payment_id'  => $_paymentId ,  'razorpay_order_id' => $_orderId);
        $order  = $api->utility->verifyPaymentSignature($attributes);
        return true;
    }
    catch(\Exception $e)
    {
        // If Signature is not correct its give a excetption so we use try catch
        return false;
    }
}

public function paymentfailed(Request $req){
//    dd($req);

   $details = [
    'mail_type' => 'payment_failed',
    'subject' => 'Failed! - Payment of 99 Rs (Ninty Rupees) against order number ' .$req->all()['error_metadata_order_id'] . ' is failed !',
    'title' => "Payment Failed Mail From Servesmile",

    'career_data_id' => $req->all()['career_data_id'],
    'full_name' => $req->all()['full_name'],
    'email' => $req->all()['email'],
    'contact' => $req->all()['contact'],
    'reciept_id' => $req->all()['reciept_id'],
    'amount_in_rs' => "99",
    'amount' => "9900",
    'description' => 'ONE TIME FEE (Lifetime)',
    'order_id' => $req->all()['error_metadata_order_id'],
    'created_at' => $req->all()['created_at'],
    'currency' => 'INR',
    'ss_registration_code' => $req->all()['ss_registration_code'],
    'rzp_signature' => '',
    'rzp_paymentid' => $req->all()['error_metadata_payment_id'],
    'payment_status' => "0",

    'error_code'=> $req->all()['error_code'],
    'error_desccription'=> $req->all()['error_desccription'],
    'error_source'=> $req->all()['error_source'],
    'error_step'=> $req->all()['error_step'],
    'error_reason'=> $req->all()['error_reason'],
    'error_metadata_order_id'=> $req->all()['error_metadata_order_id'],
    'error_metadata_payment_id'=> $req->all()['error_metadata_payment_id'],
];

    $data = (new SS_Job_Payment_Details)->addCareerPaymentDetails($details);
    Mail::to($req->all()['email'])->cc('hr@servesmile.in')->bcc('servesmile21@gmail.com')->send(new career($details));
    // Mail::to($req->all()['email'])->cc('servesmile21@gmail.com')->send(new career($details));

    return view('payment-failed-page');
}


}
