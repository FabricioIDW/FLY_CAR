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
        Schema::create('reserves', function (Blueprint $table) {
            $table->id();
            $table->timestamp('dateTimeGenerated')->useCurrent();
            $table->enum('reserveState', ['concretada', 'habilitada']);
            $table->float('amount');
            $table->timestamp('dateTimeExpiration')->useCurrent();
            $table->unsignedBigInteger('quotation_id');
            $table->unsignedBigInteger('payment_id');
            $table->timestamps();
            $table->foreign('quotation_id')->references('id')->on('quotations');
            $table->foreign('payment_id')->references('id')->on('payments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reserves');
    }
};
