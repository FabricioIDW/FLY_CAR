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
        Schema::create('modelos_accesorios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idModelo');
            $table->unsignedBigInteger('idAccesorio');
            $table->float('precio');
            $table->timestamps();
            $table->foreign('idModelo')->references('id')->on('modelos');
            $table->foreign('idAccesorio')->references('id')->on('accesorios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modelos_accesorios');
    }
};
