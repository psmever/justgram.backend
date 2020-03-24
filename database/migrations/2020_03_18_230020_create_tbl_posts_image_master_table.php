<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblPostsImageMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_posts_image_master', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('post_id')->nullable(false)->index()->comment('post id.');
            $table->unsignedBigInteger('image_id')->nullable()->index()->comment('post id.');
            $table->timestamps();

            $table->foreign('post_id')->references('id')->on('tbl_posts_master')->onDelete('cascade');
            $table->foreign('image_id')->references('id')->on('tbl_cloudinary_images_master')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_posts_image_master');
    }
}
