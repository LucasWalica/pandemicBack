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
        Schema::create('personaje_', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('specialSKill');
            $table->foreignId('partida_id')->nullable()->constrained('partida')->onDelete('cascade');
            $table->boolean('movido')->default(false);
            $table->foreignId('ciudad_id')->constrained('ciudad')->onDelete('cascade'); // Cambiado de 'id' a 'ciudad_id'
            $table->integer('turno_comienzo')->default(0);
            $table->boolean('en_accion')->default(false);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personaje_');
    }
};
