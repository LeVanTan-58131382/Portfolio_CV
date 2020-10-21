<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeatherConditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Weather_Conditions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('humidity_from')->nullable(); // độ ẩm
            $table->integer('humidity_to')->nullable();
            $table->integer('temperature_from')->nullable(); // nhiệt độ
            $table->integer('temperature_to')->nullable();
            $table->string('light'); // ánh sáng
            $table->string('ph')->nullable();
            $table->unsignedInteger('land_id');
            //$table->foreign('land_id')->references('id')->on('Lands')->onDelete('cascade');
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
        Schema::dropIfExists('Weather_Conditions');
    }
}
