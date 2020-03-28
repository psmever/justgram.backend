<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblPostsCommentsMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_posts_comments_master', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('post_id')->nullable(false)->index()->comment('post id.');
            $table->unsignedBigInteger('user_id')->nullable(false)->comment('사용자 id');
            $table->text('contents')->nullable(false)->comment('내용.');
            $table->enum('active', ['Y', 'N'])->default('Y')->comment('공개 여부.');
            $table->timestamps();

            $table->foreign('post_id')->references('id')->on('tbl_posts_master')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('tbl_users_master')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_posts_comments_master');
    }
}
