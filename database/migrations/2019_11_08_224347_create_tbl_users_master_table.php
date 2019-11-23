<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblUsersMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_users_master', function (Blueprint $table) {
            $table->bigIncrements('id');
	        $table->string('user_uuid', 50)->unique()->comment('사용자 uuid');
	        $table->string('user_type', 6)->default('A02001')->comment('사용자 타입');
	        $table->string('user_state', 6)->default('A10000')->comment('사용자 상태');
	        $table->string('user_level', 6)->default('A20000')->comment('사용자 레벨');

	        $table->string('name');
	        $table->string('email')->unique();

	        $table->string('password');
	        $table->rememberToken();

	        $table->enum('user_state_flag', ['Y', 'N'])->default('Y')->comment('사용자 상태(정상인지 아닌지)');
	        $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();


	        $table->foreign('user_type')->references('code_id')->on('tbl_codes_master')->onDelete('cascade');
	        $table->foreign('user_state')->references('code_id')->on('tbl_codes_master')->onDelete('cascade');
	        $table->foreign('user_level')->references('code_id')->on('tbl_codes_master')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::table('tbl_users_master', function (Blueprint $table) {
		    $table->dropForeign('tbl_users_master_user_level_foreign');
		    $table->dropForeign('tbl_users_master_user_state_foreign');
		    $table->dropForeign('tbl_users_master_user_type_foreign');
		    $table->dropColumn(['user_type', 'user_state', 'user_level', ]);
	    });

        Schema::dropIfExists('tbl_users_master');
    }
}
