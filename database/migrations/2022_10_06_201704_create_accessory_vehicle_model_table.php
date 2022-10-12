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
        Schema::create('accessory_vehicle_model', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('accessory_id');
            $table->unsignedBigInteger('vehicle_model_id');
            $table->float('price',)->default(3500.00);
            $table->timestamps();
            $table->foreign('accessory_id')->references('id')->on('accessories');
            $table->foreign('vehicle_model_id')->references('id')->on('vehicle_models');
            $table->unique(['accessory_id', 'vehicle_model_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accessory_vehicle_model');
    }
};
