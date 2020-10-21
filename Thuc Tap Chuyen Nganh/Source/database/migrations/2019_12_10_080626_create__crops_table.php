<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCropsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Crops', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('quantity_max_stages_dev')->default(0);
            $table->string('density');
            $table->longText('description')->nullable();
            $table->longText('pests_and_diseases')->nullable();
            $table->integer('ph_from')->nullable();
            $table->integer('ph_to')->nullable();
            $table->string('image');
            $table->integer('typecrop_id');
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
        Schema::dropIfExists('Crops');
    }
}
