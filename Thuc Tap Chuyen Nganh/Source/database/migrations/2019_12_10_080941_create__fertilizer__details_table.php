<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFertilizerDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Fertilizer_Details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('land_id');
            //$table->foreign('land_id')->references('id')->on('Lands')->onDelete('cascade');
            $table->unsignedInteger('fertilizer_id');
            $table->integer('type_fertilizer_id');
            //$table->foreign('fertilizer_id')->references('id')->on('Fertilizers')->onDelete('cascade');
            $table->integer('day_fer'); // ngày bón phân
            $table->integer('mass');
            $table->string('implementer')->nullable(); // người thực hiện
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
        Schema::dropIfExists('Fertilizer_Details');
    }
}
