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
        Schema::create('ciudad', function (Blueprint $table) {
            $table->id();
           $table->string('name');
           $table->foreignId('partida_id')->constrained('partida')->onDelete('cascade');
           $table->boolean('centro_investigacion')->default(false);
           $table->integer('coordenadasX');
           $table->integer('coordenadasY');
           $table->integer('eVerde');
           $table->integer('eRoja');
           $table->integer('eAmarilla');
           $table->integer('eAzul');
           $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ciudad');
    }
};
