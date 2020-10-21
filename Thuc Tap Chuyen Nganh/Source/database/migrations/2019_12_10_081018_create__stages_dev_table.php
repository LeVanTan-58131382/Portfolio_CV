<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStagesDevTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Stages_dev', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('numerical_order'); // chỉ số của giai đoạn, kèm theo để khi tìm kiếm giai đoạn nào của cây trồng nào, ví dụ: tìm kiếm giai đoạn 1 của cây trồng có crop_id = 1
            $table->string('name');
            $table->integer('start_day');
            $table->integer('end_day');
            $table->text('fertilizer')->nullable(); // phân bón phù hợp cho giai đoạn này
            $table->text('fertilizer_mass')->nullable()->default(0); // lượng phân cần bón cho mỗi lần bón
            $table->integer('water_volume')->nullable()->default(0); // lượng nước cần tưới cho mỗi lần tưới
            $table->longText('description')->nullable();
            $table->unsignedInteger('crop_id');
            $table->integer('have_fertilized')->default(0); // bổ sung phần đã bón phân cho giai đoạn này - mặc định là 1 lần cho mỗi giai đoạn người dùng có thể bón thêm
            //$table->foreign('crop_id')->references('id')->on('Crops')->onDelete('cascade'); 

            // các yếu tố môi trường phù hợp với từng giai đoạn cây trồng
            $table->integer('suitable_humidity_from'); // độ ẩm thích hợp từ
            $table->integer('suitable_humidity_to'); // độ ẩm thích hợp đến
            $table->string('suitable_light'); // độ sáng thích hợp
            $table->integer('suitable_temperature_from'); // nhiệt độ thích hợp từ
            $table->integer('suitable_temperature_to'); // nhiệt độ thích hợp đến
            $table->integer('suitable_ph_from'); // độ ph thích hợp từ
            $table->integer('suitable_ph_to'); // độ ph thích hợp đến
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
        Schema::dropIfExists('Stages_dev');
    }
}
