<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFertilizersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Fertilizers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('mass'); // khối lượng phân bón
            $table->unsignedInteger('type_fertilizer_id');
            //$table->foreign('type_fertilizer_id')->references('id')->on('Type_Fertilizers')->onDelete('cascade');
            $table->longText('description')->nullable();
            $table->float('mass_reduces_1_pH_above_30_m')->nullable(); // lượng phân cần dùng để giảm 1 độ ph của mảnh đất rộng 30 mét vuông
            $table->float('mass_increase_1_pH_above_30_m')->nullable(); // lượng phân cần dùng để tăng 1 độ ph của mảnh đất rộng 30 mét vuông
            $table->float('mass_suiable_30_m')->nullable(); // lượng phân cần dùng của mảnh đất rộng 30 mét vuông
            $table->integer('effective_time')->nullable(); // khoảng cách ngày mà phân bón sẽ mang lại hiệu quả - đối với loại phân tăng hoặc giảm độ ph của đất thì có nhiều loại cần có thời gian để có thể mang lại hiệu quả.
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
        Schema::dropIfExists('Fertilizers');
    }
}
