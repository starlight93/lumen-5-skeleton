<?php

namespace App\Http\Controllers;
use Illuminate\Support\Carbon;

class MailController
{
    public function send($to,$to_name, $subject,$body,$bodyAlt)
    {
        $id=null;
        try{

            $transport = (new \Swift_SmtpTransport('smtp.gmail.com',env('MAIL_PORT',465),'tls'))
            ->setUsername(env('MAIL_USERNAME'))
            ->setPassword(env('MAIL_PASSWORD'))
            ;

            // Create the Mailer using your created Transport
            $mailer = new \Swift_Mailer($transport);

            // Create a message
            $message = (new \Swift_Message($subject))
                ->setFrom([env('MAIL_FROM','lumen@localhost.app') => env('MAIL_FROM_NAME','LUMEN APP')])
                ->setTo([$to => 'we'.$to_name])
                ->setBody($body,'text/html')
                ->addPart($bodyAlt,'text/plain')
                ;
            $id = \DB::table('oauth_sent_mail')->insertGetId([
                "email"=>$to,
                "subject"=>$subject,
                "created_at"=>Carbon::now(),
                "updated_at"=>Carbon::now(),
            ]);
            // Send the message
            $result = $mailer->send($message);
            if($result){
                \DB::table('oauth_sent_mail')->where( "id", $id )->update([
                    "status"=>"sent",
                    "updated_at"=>Carbon::now(),
                ]);
                return true;
            }else{
                \DB::table('oauth_sent_mail')->where( "id", $id )->update([
                    "status"=>"failed",
                    "info"=>"email destination maybe not exist",
                    "updated_at"=>Carbon::now(),
                ]);
                return "Error happened when trying to send to your email, Please Contact Administrator";
            }
        }catch(\Exception $e){
            \DB::table('oauth_sent_mail')->where( "id", $id )->update([
                "status"=>"failed",
                "info"=>$e->getMessage(),
                "updated_at"=>Carbon::now(),
            ]);
            return $e->getMessage();
        }
    }
}