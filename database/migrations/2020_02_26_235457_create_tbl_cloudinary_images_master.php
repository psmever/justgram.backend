<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblCloudinaryImagesMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_cloudinary_images_master', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_uuid', 50)->nullable(false)->comment('사용자 uuid.');
            $table->string('image_category', 6)->nullable(false)->comment('이미지 구분');
            $table->string('public_id', 50)->nullable(false)->comment('public_id.');
            $table->string('signature', 50)->nullable(false)->comment('signature.');
            $table->biginteger('version')->nullable(false)->comment('version.');
            $table->integer('width')->nullable(false)->comment('width.');
            $table->integer('height')->nullable(false)->comment('height.');
            $table->char('format', 20)->nullable(false)->comment('이미지 포멧.');
            $table->string('original_filename', 100)->nullable(false)->comment('오리지날 이미지 명.');
            $table->string('url', 255)->nullable(false)->comment('이미지 일반 URL');
            $table->string('usecure_url', 255)->nullable(false)->comment('이미지 ssl URL');
            $table->biginteger('bytes')->nullable(false)->comment('용향(bytes)');
            $table->string('server_time', 50)->nullable(false)->comment('서버 시간.');

            $table->timestamps();
            $table->foreign('user_uuid')->references('user_uuid')->on('tbl_users_master')->onDelete('cascade');
            $table->foreign('image_category')->references('code_id')->on('tbl_codes_master')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_cloudinary_images_master');
    }
}
