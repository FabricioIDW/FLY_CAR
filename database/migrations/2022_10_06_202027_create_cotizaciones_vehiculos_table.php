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
        Schema::create('cotizaciones_vehiculos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idCotizacion');
            $table->unsignedBigInteger('idVehiculo');
            $table->timestamps();
            $table->foreign('idCotizacion')->references('id')->on('cotizaciones');
            $table->foreign('idVehiculo')->references('id')->on('vehiculos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cotizaciones_vehiculos');
    }
};
