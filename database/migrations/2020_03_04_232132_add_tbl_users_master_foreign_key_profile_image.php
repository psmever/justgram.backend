<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTblUsersMasterForeignKeyProfileImage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_users_master', function($table)
        {
            $table->biginteger('profile_image')->unsigned()->nullable()->after('password');
            $table->foreign('profile_image')->references('id')->on('tbl_cloudinary_images_master')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_users_master', function($table)
        {
            $table->dropForeign('tbl_users_master_profile_image_foreign');
            $table->dropColumn('profile_image');
        });
    }
}
