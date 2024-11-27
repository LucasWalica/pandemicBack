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
           $table->string('name')->default('desconocido');
           $table->foreignId('partida_id')->constrained('partida')->onDelete('cascade');
           $table->boolean('centro_investigacion')->default(false);
           $table->integer('coordenadasX');
           $table->integer('coordenadasY');
           $table->integer('eVerde')->default(0);
           $table->integer('eRoja')->default(0);
           $table->integer('eAmarilla')->default(0);
           $table->integer('eAzul')->default(0);
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
