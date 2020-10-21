<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Lands', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('quanty_crops')->nullable(); // số lượng cây trồng
            $table->integer('square'); // diện tích land
            $table->integer('dev_days'); // số ngày phát triển kể từ khi tạo land
            $table->integer('virtual_dev_days')->default(0); // số ngày phát triển ảo kể từ sau khi thu hoạch
            $table->integer('have_watered')->default(0); // = 1: land đã dc tưới nước, = 0: land chưa được tưới nước
            $table->integer('have_drip_irrigation')->default(0); // tưới nước nhỏ giọt
            $table->integer('have_watering_misting')->default(0); // tưới nước phun sương
            $table->integer('have_fertilized')->default(0); // = 1: land đã dc tưới phân, = 0: land chưa được tưới phân
            $table->integer('have_decreased_pH')->default(0); // = 1: land đã giảm độ ph, = 0: land chưa giảm độ ph
            $table->integer('have_increased_pH')->default(0); // = 1: land đã tăng độ ph, = 0: land chưa tăng độ ph
            $table->unsignedInteger('crop_id');
            //$table->foreign('crop_id')->references('id')->on('Crops')->onDelete('cascade');
            $table->integer('farm_id')->nullable();// farm id
            $table->integer('deleted')->default(0);
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
        Schema::dropIfExists('Lands');
    }
}
