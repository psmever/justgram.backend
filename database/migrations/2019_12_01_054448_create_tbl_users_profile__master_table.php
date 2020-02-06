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

	        $table->string('user_uuid', 50)->primary()->comment('사용자 uuid');

	        $table->string('real_name', 255)->nullable();
	        $table->string('web_site', 255)->nullable();
	        $table->text('about')->nullable();
	        $table->string('telephone', 255)->nullable();
	        $table->string('gender', 6)->nullable();

            $table->timestamps();

	        $table->foreign('user_uuid')->references('user_uuid')->on('tbl_users_master')->onDelete('cascade');
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
