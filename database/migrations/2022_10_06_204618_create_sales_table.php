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
            $table->float('comission', 20)->nullable()->default(0);
            $table->boolean('concretized')->default(true);
            $table->unsignedBigInteger('payment_id')->nullable()->default(null);
            $table->unsignedBigInteger('quotation_id')->nullable()->default(null);
            $table->unsignedBigInteger('seller_id')->nullable()->default(null);
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
