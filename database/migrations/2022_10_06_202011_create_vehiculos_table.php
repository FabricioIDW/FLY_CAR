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
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->id();
            $table->string('nroChasis', 17)->unique();
            $table->float('precio');
            $table->text('descripcion');
            $table->year('anio');
            $table->text('imagen');
            $table->boolean('habilitado')->default(true);
            $table->enum('estadoVehiculo', ['vendido', 'reservado']);
            $table->boolean('eliminado')->default(false);
            $table->unsignedBigInteger('idModelo');
            $table->unsignedBigInteger('idOferta');
            $table->timestamps();
            $table->foreign('idModelo')->references('id')->on('modelos');
            $table->foreign('idOferta')->references('id')->on('ofertas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehiculos');
    }
};
