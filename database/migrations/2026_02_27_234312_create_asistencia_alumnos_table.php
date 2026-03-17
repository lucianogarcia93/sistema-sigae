<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asistencia_alumnos', function (Blueprint $table) {

            $table->id();

            // Alumno relacionado (solo bloquea si se intenta borrar)
            $table->foreignId('alumno_id')
                  ->constrained('alumnos')
                  ->onDelete('restrict');

            $table->foreignId('curso_id')
                  ->constrained('cursos')
                  ->onDelete('restrict');

            $table->date('fecha');

            // ESTADOS DE ASISTENCIA
            $table->enum('estado', [
                'presente',
                'ausente',
                'justificado'
            ])->default('presente');

            // Control de estado lógico de la asistencia
            $table->boolean('activo')->default(true);

            $table->timestamps();

            // Evita duplicados: mismo alumno, mismo curso, misma fecha
            $table->unique(['alumno_id', 'curso_id', 'fecha']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asistencia_alumnos');
    }
};