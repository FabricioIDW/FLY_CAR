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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('chassis', 17)->unique();
            $table->float('price', 20);
            $table->text('description');
            $table->year('year');
            $table->text('image');
            $table->boolean('enabled')->default(true);
            $table->enum('vehicleState', ['sold', 'reserved', 'availabled'])->default('availabled');
            $table->boolean('removed')->default(false);
            $table->unsignedBigInteger('vehicle_model_id');
            $table->unsignedBigInteger('offer_id');
            $table->timestamps();
            $table->foreign('vehicle_model_id')->references('id')->on('vehicle_models');
            $table->foreign('offer_id')->references('id')->on('offers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
};
