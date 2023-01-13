<?php

namespace App\Models;

use GuzzleHttp\Client;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class SS_Discount_Card extends Model
{

    protected $table = "ss_discount_card";
    protected $primaryKey = "d_card_id";
    public $timestamp = false;

    use HasFactory;

    public function getDiscountCard($ss_user_id){

        $data = DB::table('ss_discount_card')->where('ss_user_id', $ss_user_id)->first();

        if($data == null){

            $select = array(
                'ss_users.ss_user_id','states.state_id','states.state_abbreviation','ss_users.contact','agent_code'
            );

            $user = DB::table('ss_users')->select($select)
                   ->join('ss_user_locations', 'ss_user_locations.ss_user_id', '=' ,'ss_users.ss_user_id')
                   ->join('states', 'states.state_id', '=', 'ss_user_locations.state_id')
                   ->where('ss_users.ss_user_id', $ss_user_id)->first();

            $generate_card_number = $this->generateCardNumber($user);

            $user_data = User::where('ss_user_id', $ss_user_id)->first();
            $user_data->d_card_id = $generate_card_number->d_card_id;
            $user_data->save();

            $response["user"] = $user;
            $response["user_data"] = $user_data;
            $response["data"] = $generate_card_number;

            return response()->json($response);

        }else{
            $response["data"] = $data;
            return response()->json($response);
        }
    }

    public function generateCardNumber($user)
    {
        $select = array(
            'd_card_id', 'discount_card_sr_no', 'discount_card_no',
        );

        $data = new SS_Discount_Card();
        $card_data = DB::table('ss_discount_card')->select($select)->where('state_id', $user->state_id)
                     ->orderBy('d_card_id', 'desc')->first();

        $quantity = 1;
        if ($card_data == null) {
            $i = 1;

            $quantity = $i + $quantity;

            for ($i = 1; $i < $quantity; $i++) {

                $data = new SS_Discount_Card();
                $data->discount_card_sr_no = $i;
                $data->discount_card_no = strtoupper('M' . $user->state_abbreviation . $i);
                $data->state_id = $user->state_id;
                $data->state_abbreviation = $user->state_abbreviation;
                $data->is_virtual_physical = 1;
                $data->ss_user_id = $user->ss_user_id;
                $data->primary_contact = $user->contact;
                $data->card_status = 1;
                $data->reserved_by = 0;

                $data->agent_code = $user->agent_code;
                $data->validity_in_days = 30;
                $data->start_date = Carbon::now();
                $data->end_date = Carbon::now()->addDays(30);

                $data->created_at = Carbon::now();
                $data->updated_at = Carbon::now();
                $data->save();
            }

        } else {
            $i = $card_data->discount_card_sr_no + 1;
            $quantity = $i + $quantity;

            for ($i = $i; $i < $quantity; $i++) {

                $data = new SS_Discount_Card();
                $data->discount_card_sr_no = $i;
                $data->discount_card_no = strtoupper('M' . $user->state_abbreviation . $i);
                $data->state_id = $user->state_id;
                $data->state_abbreviation = $user->state_abbreviation;
                $data->is_virtual_physical = 1;
                $data->ss_user_id = $user->ss_user_id;
                $data->primary_contact = $user->contact;
                $data->card_status = 1;
                $data->reserved_by = 0;

                $data->agent_code = $user->agent_code;
                $data->validity_in_days = 30;
                $data->start_date = Carbon::now();
                $data->end_date = Carbon::now()->addDays(30);

                $data->created_at = Carbon::now();
                $data->updated_at = Carbon::now();
                $data->save();
            }

        }
        return $data;
    }

}
