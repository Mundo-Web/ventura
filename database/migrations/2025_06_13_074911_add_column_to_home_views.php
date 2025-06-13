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
        Schema::table('home_views', function (Blueprint $table) {
            $table->string('subtitle1section')->nullable();
            $table->string('titledate1section')->nullable();

            $table->string('button2section')->nullable();
           
            $table->string('description8section')->nullable();
            $table->string('title8section')->nullable();
            $table->string('button8section')->nullable();

            $table->string('button4section')->nullable();

            $table->string('button5section')->nullable();

            $table->string('button6section')->nullable();
            $table->string('address6section')->nullable();
            $table->string('number6section')->nullable();
            $table->string('mail6section')->nullable();
            $table->string('atencion6section')->nullable();

            $table->string('titledate9section')->nullable();
            $table->string('description9section')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('home_views', function (Blueprint $table) {
            //
        });
    }
};
