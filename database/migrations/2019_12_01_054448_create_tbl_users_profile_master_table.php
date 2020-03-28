<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblUsersProfileMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_users_profile_master', function (Blueprint $table) {

	        $table->unsignedBigInteger('user_id')->primary()->comment('사용자 id');

	        $table->string('name', 255)->nullable();
	        $table->string('web_site', 255)->nullable();
	        $table->text('bio')->nullable();
	        $table->string('phone_number', 255)->nullable();
	        $table->string('gender', 6)->nullable();

            $table->timestamps();

	        $table->foreign('user_id')->references('id')->on('tbl_users_master')->onDelete('cascade');
	        $table->foreign('gender')->references('code_id')->on('tbl_codes_master')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_users_profile_master');
    }
}
