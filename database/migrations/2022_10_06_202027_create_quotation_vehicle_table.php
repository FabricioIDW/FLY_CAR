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
        Schema::create('quotation_vehicle', function (Blueprint $table) {
            $table->unsignedBigInteger('quotation_id');
            $table->unsignedBigInteger('vehicle_id');
            $table->timestamps();
            $table->foreign('quotation_id')->references('id')->on('quotations');
            $table->foreign('vehicle_id')->references('id')->on('vehicles');
            $table->primary(['quotation_id', 'vehicle_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quotation_vehicle');
    }
};
