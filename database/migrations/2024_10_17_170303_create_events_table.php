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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id'); // ID del producto (relación con tabla Products)
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->string('sku')->nullable();
            $table->date('checkin'); // Fecha de check-in
            $table->date('checkout'); // Fecha de check-out
            $table->string('description')->nullable(); // Descripción de la reserva
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
