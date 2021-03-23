<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\User;
use Illuminate\Support\Carbon;
class OauthUser extends Migration
{
    public function up()
    {
        $this->down();
        Schema::create('oauth_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('username',60)->unique()->nullable();
            $table->string('password')->nullable();
            $table->string('provider')->nullable()->default("default");
            $table->string('provider_email')->nullable();
            $table->string('provider_username')->nullable();
            $table->string('provider_avatar')->nullable();
            $table->text('provider_token')->nullable();
            $table->string('auth')->nullable()->default("public");
            $table->string('branch')->nullable()->default("default");
            $table->string('status',20)->default("ACTIVE");
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
        $hasher = app()->make( 'hash' );
        User::create([
            'name' => "admin",
            'username' => "admin@admin.id",
            'email' => "admin@admin.id",
            'email_verified_at'=>Carbon::now(),
            'password' => $hasher->make("admin123()")
        ]);
    }
    
    public function down()
    {
        Schema::dropIfExists('oauth_user');
    }
}
