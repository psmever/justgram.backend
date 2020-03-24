<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblPostsTagMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_posts_tag_master', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('post_id')->nullable(false)->index()->comment('post id.');
            $table->text('hash_tag', 255)->nullable()->comment('해시 테그.');
            $table->timestamps();

            $table->foreign('post_id')->references('id')->on('tbl_posts_master')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_posts_tag_master');
    }
}
