<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accessory_quotation_vehicle', function (Blueprint $table) {
            $table->unsignedBigInteger('accessory_id');
            $table->unsignedBigInteger('quotation_id');
            $table->unsignedBigInteger('vehicle_id');
            $table->timestamps();
            $table->foreign('accessory_id')->references('id')->on('accessories');
            $table->foreign('quotation_id')->references('id')->on('quotations');
            $table->foreign('vehicle_id')->references('id')->on('vehicles');
            $table->primary(['accessory_id', 'quotation_id', 'vehicle_id'], 'a_q_v');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accessory_quotation_vehicle');
    }
};
