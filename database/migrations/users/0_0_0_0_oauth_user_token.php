<?php
// namespace Database\Migrations\Defaults;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Carbon;

class OauthUserToken extends Migration
{
    public function up()
    {
        $this->down();
        Schema::create('oauth_user_token', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('oauth_user_id')->nullable();
            $table->longText('token')->nullable();
            $table->dateTime('logged_in_at')->nullable();
            $table->dateTime('logged_out_at')->nullable();
            $table->dateTime('revoked_at')->nullable();
            $table->timestamps();
        });
        \DB::table("oauth_user_token")->insert([
            'oauth_user_id' => 1,
            'token' => "admin123()",
            'logged_in_at' => Carbon::now()
        ]);
    }
    public function down()
    {
        Schema::dropIfExists('oauth_user_token');
    }
}
