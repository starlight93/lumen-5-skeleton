<?php
// namespace Database\Migrations\Defaults;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OauthSentMail extends Migration
{
    public function up()
    {
        $this->down();
        Schema::create('oauth_sent_mail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('oauth_user_id')->nullable();
            $table->string('email')->nullable();
            $table->string('subject')->nullable();
            $table->string('status')->nullable()->default("sending");
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('oauth_sent_mail');
    }
}
