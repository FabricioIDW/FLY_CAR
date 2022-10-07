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
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->timestamp('fechaHoraGenerado')->useCurrent();
            $table->enum('estadoReserva', ['concretada', 'habilitada']);
            $table->float('importe');
            $table->timestamp('fechaHoraVencimiento')->useCurrent();
            $table->unsignedBigInteger('idCotizacion');
            $table->integer('nroPago');
            $table->timestamps();
            $table->foreign('idCotizacion')->references('id')->on('cotizaciones');
            $table->foreign('nroPago')->references('nroPago')->on('pagos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservas');
    }
};
