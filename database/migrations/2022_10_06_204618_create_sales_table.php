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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->timestamp('dateTimeGenerated')->useCurrent();
            $table->float('comission');
            $table->boolean('concretized');
            $table->unsignedBigInteger('payment_id');
            $table->unsignedBigInteger('quotation_id');
            $table->unsignedBigInteger('seller_id');
            $table->timestamps();
            $table->foreign('payment_id')->references('id')->on('payments');
            $table->foreign('quotation_id')->references('id')->on('quotations');
            $table->foreign('seller_id')->references('id')->on('sellers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
};
