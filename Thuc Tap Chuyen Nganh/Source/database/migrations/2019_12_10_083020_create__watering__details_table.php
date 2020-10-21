<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWateringDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Watering_Details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('water_volume'); // lượng nước tưới cho mỗi lần tưới
            $table->unsignedInteger('land_id');
            //$table->foreign('land_id')->references('id')->on('Lands')->onDelete('cascade');
            $table->unsignedInteger('water_tank_id');
            //$table->foreign('water_tank_id')->references('id')->on('Water_tanks')->onDelete('cascade');
            $table->integer('day_water'); // ngày tưới nước
            $table->string('implementer')->nullable(); // người thực hiện
            $table->integer('deleted')->default(0);
            $table->integer('method_id'); // cách thức tưới 
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
        Schema::dropIfExists('Watering_Details');
    }
}
