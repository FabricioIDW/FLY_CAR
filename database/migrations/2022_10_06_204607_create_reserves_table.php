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
            $table->enum('reserveState', ['enabled', 'disabled', 'canceled'])->default('enabled');
            $table->float('amount', 20)->default(0);
            $table->timestamp('dateTimeExpiration')->useCurrent();
            $table->unsignedBigInteger('quotation_id')->nullable()->default(null);
            $table->unsignedBigInteger('payment_id')->nullable()->default(null);
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
