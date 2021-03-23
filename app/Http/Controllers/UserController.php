<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Validator;

class UserController extends Controller
{
    public function login( Request $request ){
        $validator = Validator::make( $request->all() , [
            "email"=>"required",
            "password"=>"required"
        ] );
        
        if ($validator->fails()) {
            return response()->json( [
                "message"=> $validator->errors()
            ], 401 );
        }
        
        $data = \DB::table("oauth_user")
                    ->select("id","name","username","email","auth","branch","password")
                    ->where( "email", $request->email )
                    ->first();

        if(!$data){
            return response()->json( [
                "message" => "user does not exist"
            ],401 );
        }
        if (!Hash::check($request->password, $data->password)) {
            return response()->json( [
                "message" => "wrong password"
            ],401 );
        }
        
        $generatedToken = base64_encode( uniqid().$data->id );
        \DB::table ( "oauth_user_token" )->insert([
            "oauth_user_id" => $data->id,
            "token"=> $generatedToken,
            "logged_in_at"=>Carbon::now()
        ]);
        return array_merge( ( array ) $data,[
            "token" => $generatedToken,
            "type" => "custom"
        ]);
    }
}
