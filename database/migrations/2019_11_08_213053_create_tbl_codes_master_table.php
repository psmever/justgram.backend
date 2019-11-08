<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblCodesMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_codes_master', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('group_id', 6);
            $table->char('code_id', 6)->nullable()->unique();
            $table->char('group_name', 100)->nullable();
            $table->char('code_name', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_codes_master');
    }
}
