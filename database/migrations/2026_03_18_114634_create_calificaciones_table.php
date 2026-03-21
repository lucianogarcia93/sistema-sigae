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
        Schema::create('calificaciones', function (Blueprint $table) {
            $table->id();

            // Relaciones
            $table->foreignId('alumno_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->foreignId('materia_curso_id')
                  ->constrained('curso_materia') // 👈 IMPORTANTE
                  ->cascadeOnDelete();

            // Datos de la nota
            $table->decimal('nota', 4, 2); // Ej: 8.50
            $table->string('tipo')->nullable(); // parcial, final, tp
            $table->date('fecha')->nullable();

            $table->timestamps();

            // Evitar duplicados
            $table->unique(['alumno_id', 'materia_curso_id', 'tipo']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calificaciones');
    }
};