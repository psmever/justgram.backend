<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblPostsMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_posts_master', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_uuid', 50)->nullable(false)->comment('사용자 uuid');
            $table->text('contents')->nullable(false)->comment('글 내용.');
            $table->enum('post_active', ['Y', 'N'])->default('Y')->comment('글상태.');
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
        Schema::dropIfExists('tbl_posts_master');
    }
}
