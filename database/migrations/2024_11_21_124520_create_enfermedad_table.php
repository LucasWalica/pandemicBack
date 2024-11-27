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
        Schema::create('enfermedad', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('turnos_para_curarse');
            $table->integer('infeccion_a_colindantes')->default(1);
            $table->foreignId('partida_id')->constrained('partida')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enfermedad');
    }
};
