<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowFerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('follow_fer', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_land');
            $table->integer('numerical_order'); // giai đoạn phát triển thứ mấy của cây trồng thuộc land đó
            $table->integer('have_fer')->default(0);
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
        Schema::dropIfExists('follow_fer');
    }
}
