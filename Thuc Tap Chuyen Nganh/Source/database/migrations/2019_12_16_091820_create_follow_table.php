<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('follow', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_land');
            $table->integer('total_water');// tổng lượng nước đã tưới
            $table->integer('total_fer');// tổng lượng phân đã bón
            $table->integer('day_harvest');// ngày thu hoạch
            $table->integer('old')->default(0); // old = 1, record thu hoạch của land đó trước đây, old = 0: record thu hoạch của land đó hiện tại 
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
        Schema::dropIfExists('follow');
    }
}
