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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->timestamp('fechaHoraGenerada')->useCurrent();
            $table->float('comision');
            $table->boolean('concretada');
            $table->integer('nroPago');
            $table->unsignedBigInteger('idCotizacion');
            $table->string('dniVendedor', 8);
            $table->timestamps();
            $table->foreign('nroPago')->references('nroPago')->on('pagos');
            $table->foreign('idCotizacion')->references('id')->on('cotizaciones');
            $table->foreign('dniVendedor')->references('dniVendedor')->on('vendedores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ventas');
    }
};
