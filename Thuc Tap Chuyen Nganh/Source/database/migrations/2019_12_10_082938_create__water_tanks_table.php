<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWaterTanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Water_tanks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('volume'); // lượng nước trong bồn chứa
            $table->integer('farm_id')->nullable();// farm id
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
        Schema::dropIfExists('Water_tanks');
    }
}
