<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\DB;

class CreateTblFollowsMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_follows_master', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable(false)->index()->comment('follow 신청자 id');
            $table->unsignedBigInteger('target_id')->nullable(false)->index()->comment('follow 대상 id');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign('user_id')->references('id')->on('tbl_users_master')->onDelete('cascade');
            $table->foreign('target_id')->references('id')->on('tbl_users_master')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_follows_master');
    }
}
