<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblEmailAuthMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_email_auth_master', function (Blueprint $table) {
            $table->bigIncrements('id');
	        $table->string('user_uuid', 50)->unique()->comment('사용자 uuid');
	        $table->string('auth_code', 80)->unique()->comment('이메일 인증 코드');

	        $table->timestamp('verified_at')->nullable();
	        $table->timestamps();


	        $table->foreign('user_uuid')->references('user_uuid')->on('tbl_users_master')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_email_auth_master');
    }
}
