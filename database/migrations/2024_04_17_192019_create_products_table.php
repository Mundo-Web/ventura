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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('producto');
            $table->string('extract')->nullable();
            $table->text('description')->nullable();
            $table->decimal('precio', 12, 2)->default(0);
            $table->decimal('descuento', 12, 2)->default(0);
            $table->decimal('preciolimpieza', 12, 2)->default(0);
            $table->decimal('precioservicio', 12, 2)->default(0);
            $table->decimal('stock', 12, 2)->default(0);
            $table->decimal('costo_x_art', 12, 2)->default(0);
            $table->string('peso')->nullable();
            $table->string('imagen')->nullable();
            $table->json('atributes')->nullable();
            $table->string('sku')->nullable();
            $table->boolean('destacar')->default(false);
            $table->boolean('recomendar')->default(false);
            $table->unsignedBigInteger('categoria_id')->nullable();

            $table->integer('cuartos')->nullable();
            $table->integer('pisos')->nullable();
            $table->string('movilidad')->nullable();
            $table->integer('banios')->nullable();
            $table->string('area')->nullable();
            
            $table->string('address')->nullable();
            $table->string('inside')->nullable();
            $table->string('district')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();

            $table->string('frecuencia')->nullable();
            $table->integer('cochera')->nullable();
            $table->boolean('mascota')->default(false);
            $table->boolean('mobiliado')->default(false); /* preguntar */
            $table->text('incluye')->nullable();
            $table->text('no_incluye')->nullable();
            $table->text('disponible')->nullable();
            $table->text('no_disponible')->nullable();

            /* depa-prov-dist */
            $table->unsignedBigInteger('departamento_id')->nullable();
            $table->unsignedBigInteger('provincia_id')->nullable();
            $table->unsignedBigInteger('distrito_id')->nullable();

            $table->boolean('visible')->default(true);
            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->foreign('categoria_id')->references('id')->on('categories');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
