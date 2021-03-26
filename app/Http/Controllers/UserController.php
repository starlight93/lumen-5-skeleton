<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Http\Controllers\MailController as Mailer;
class UserController extends Controller
{
    public function login( Request $request ){
        $validator = Validator::make( $request->all() , [
            "email"=>"required",
            "password"=>"required"
        ] );
        
        if ($validator->fails()) {
            return response()->json( [
                "code"=>401,
                "message"=> $validator->errors()
            ], 401 );
        }
        
        $data = \DB::table("oauth_user")
                    ->select("id","name","username","email","auth","branch","password")
                    ->where( "email", $request->email )
                    ->first();

        if(!$data){
            return response()->json( [
                "code"=>401,
                "message" => "user does not exist"
            ],401 );
        }
        if (!Hash::check($request->password, $data->password)) {
            return response()->json( [
                "code"=>401,
                "message" => "wrong password"
            ],401 );
        }
        
        $generatedToken = base64_encode( uniqid().$data->id );
        \DB::table ( "oauth_user_token" )->insert([
            "oauth_user_id" => $data->id,
            "token"=> $generatedToken,
            "logged_in_at"=>Carbon::now(),
            "created_at"=>Carbon::now(),
            "updated_at"=>Carbon::now()
        ]);
        return array_merge( ( array ) $data,[
            "token" => $generatedToken,
            "type" => "custom"
        ]);
    }
    
    public function logout( Request $request ){
        \DB::table ( "oauth_user_token" )
            ->where("token", $request->user()->authorization)
            ->update([
                "logged_out_at"=>Carbon::now(),
                "updated_at"=>Carbon::now()
            ]);
        return response()->json( [
            "code"=>200,
            "message" => "You have logged out successfully"
        ]);
    }

    public function passwordRecovery( Request $request )
    {
        $callback = $request->callback;
        $validator = Validator::make( $request->all() , [
            "email"=>"required"
        ] );
        
        if ($validator->fails()) {
            return response()->json( [
                "code"=>401,
                "message"=> $validator->errors()->all()
            ], 401 );
        }
        $user = \DB::table("oauth_user")->where("email",$request->email)->first();
        $token = null;
        if($user){
            $token = base64_encode($user->id."_".uniqid());
            \DB::table("oauth_user")->where("email",$request->email)->update(["remember_token"=>$token]);
        }else{
            return response()->json( [
                "code"=>401,
                "message" => "Email: $request->email belum terdaftar"
            ],401 );
        }
        $mailer = new Mailer;
        $subject = "Password Reset";
        $data = (object)[
            "footer"=>"Copyrights © unud.kmnu.or.id 2014-2021. All right reserved.",
            "url"=>"$callback?token=".$token,
            "pengirim"=>"KMNU Universitas Udayana"
        ];
        $body = view('password-reset-email', compact('data'))->render();
        $bodyAlt = "Silahkan akses link: $callback?token=".$token;
        $result = $mailer->send( $user->email ,$user->name, $subject,$body,$bodyAlt) ;
        if(gettype($result) !== 'boolean'){
            return response()->json( [
                "code"=>500,
                "message" => $result
            ],500);
        }

        return response()->json( [
            "code"=>200,
            "message" => "Password Recovery Link Has been Sent to Your Email. Open Your Inbox or Spam and follow the link."
        ]);
    }
    public function passwordResetCheck( Request $request )
    {
        $user = \DB::table("oauth_user")->where("remember_token",$request->token)->first();
        if(!$user){
            return response()->json( [
                "code"=>401,
                "message" => "Recovery Token is Not found or Has Expired"
            ],401);
        }
        return response()->json( [
            "code"=>200,
            "message" => "Reset Your Password"
        ]);
    }
    public function passwordReset( Request $request )
    {
        app('db');
        $validator = Validator::make( $request->all() , [
            "password"=>"required|alpha_num|confirmed|min:6|max:12",
            "token"=>"required|exists:oauth_user,remember_token"
        ]);
        
        if ($validator->fails()) {
            return response()->json( [
                "code"=>422,
                "message"=> $validator->errors()->all()
            ], 422 );
        }

        $hasher = app()->make( 'hash' );
        $user = \DB::table("oauth_user")
            ->where("remember_token",$request->token)
            ->update([
                'password' => $hasher->make($request->password),
                'remember_token'=>null,
                'updated_at'=>Carbon::now()
            ]);
        return response()->json( [
            "code"=>200,
            "message" => "Password has been changed Successfully"
        ]);
    }
}
