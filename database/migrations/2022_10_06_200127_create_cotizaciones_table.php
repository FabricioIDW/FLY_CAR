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
        Schema::create('cotizaciones', function (Blueprint $table) {
            $table->id();
            $table->timestamp('fechaHoraGenerada')->useCurrent();
            $table->float('importeFinal');
            $table->boolean('valida')->default(true);
            $table->timestamp('fechaHoraVencimiento')->useCurrent();
            $table->string('dniCliente', 8);
            $table->timestamps();
            $table->foreign('dniCliente')->references('dniCliente')->on('clientes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cotizaciones');
    }
};
