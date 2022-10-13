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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->timestamp('dateTimeGenerated')->useCurrent();
            $table->float('finalAmount', 20)->default(0);
            $table->boolean('valid')->default(true);
            $table->timestamp('dateTimeExpiration')->useCurrent();
            $table->unsignedBigInteger('customer_id')->nullable()->default(null); //Tal vez tiene que ser cliente_id
            $table->timestamps();
            $table->foreign('customer_id')->references('id')->on('customers');
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
