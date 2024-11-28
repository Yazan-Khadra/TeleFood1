<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('store_governorates', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('store_id')->references('id')->on('stores')->cascadeOnDelete();
            $table->foreignId('governorate_id')->references('id')->on('governorates')->cascadeOnDelete();
            $table->string('location');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_governorates');
    }
};
