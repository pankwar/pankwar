<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SS_Job_Payment_Details extends Model
{
    use HasFactory;
    protected $table = "ss_job_payment_details";
    protected $primaryKey = "ss_job_payment_detail_id";
    public $timestamp = false;

    public function addCareerPaymentDetails($req){
        $data = new SS_Job_Payment_Details();
        $data->career_data_id = $req["career_data_id"];
        $data->full_name = $req["full_name"];
        $data->email = $req["email"];
        $data->contact = $req["contact"];
        $data->reciept_id = $req["reciept_id"];
        $data->amount = $req["amount_in_rs"];
        $data->description = $req["description"];
        $data->rzp_order_id = $req["order_id"];
        $data->payment_date_time = $req["created_at"];
        $data->currency = $req["currency"];
        $data->payment_for = "Servesmile Career";

        $data->rzp_signature = $req["rzp_signature"];
        $data->rzp_payment_id = $req["rzp_paymentid"];
        $data->payment_status = $req["payment_status"];

        $data->created_at = Date('Y-m-d H:i:s', time());
        $data->updated_at = Date('Y-m-d H:i:s', time());


        $data->error_code = $req['error_code'];
        $data->error_desccription = $req['error_desccription'];
        $data->error_source = $req['error_source'];
        $data->error_step = $req['error_step'];
        $data->error_reason = $req['error_reason'];
        $data->error_metadata_order_id = $req['error_metadata_order_id'];
        $data->error_metadata_payment_id = $req['error_metadata_payment_id'];

        $data->save();
        return true;
    }

    public function checkAlreadyPaid($career_data_id){
        return DB::table('ss_job_payment_details')->select('payment_status')->where("career_data_id", $career_data_id)->orderBy('ss_job_payment_detail_id', 'desc')->first();
    }
}
