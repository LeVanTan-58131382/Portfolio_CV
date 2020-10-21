<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFarmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('farm', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('cultivated_area'); // tổng diện tích canh tác của land
            $table->integer('planted_area')->nullable(); // tổng diện tích đã trồng cây
            $table->integer('vacant_area')->nullable(); // tổng diện tích còn trống của cây
            $table->integer('season_id')->nullable(); 
            $table->integer('clim_Conditions_id')->nullable();
            $table->integer('current_month'); // tháng hiện tại
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
        Schema::dropIfExists('farm');
    }
}
