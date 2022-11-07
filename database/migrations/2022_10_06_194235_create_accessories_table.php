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
        Schema::create('accessories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('offer_id')->nullable()->default(null);
            $table->string('name')->default('');
            $table->integer('stock');
            $table->text('description')->default('');
            $table->boolean('enabled')->default(true);
            $table->boolean('removed')->default(false);
            $table->timestamps();
            $table->foreign('offer_id')->references('id')->on('offers')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accessories');
    }
};
