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
        Schema::create('accesorios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idOferta');
            $table->string('nombre');
            $table->integer('stock');
            $table->text('descripcion');
            $table->text('imagen');
            $table->boolean('habilitado')->default(true);
            $table->boolean('eliminado')->default(false);
            $table->timestamps();
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
        Schema::dropIfExists('accesorios');
    }
};
