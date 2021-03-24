<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest('api', function ($request) {
            if( $request->header("Authorization") ){
                return \DB::table("oauth_user_token")
                    ->selectRaw("oauth_user.id,name,email,username,provider,provider_email,provider_username,provider_avatar,provider_token,branch,auth,status,remember_token,token as authorization")
                    ->join("oauth_user","oauth_user.id","oauth_user_id")
                    ->where("token",$request->header("Authorization"))
                    ->whereNull("revoked_at")
                    ->whereNull("logged_out_at")
                    ->first();  
            }
        });
        
    }
}
