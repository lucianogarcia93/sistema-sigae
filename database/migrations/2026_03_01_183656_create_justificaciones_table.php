<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('justificaciones', function (Blueprint $table) {

            $table->id();

            // Relación con asistencia del alumno
            $table->foreignId('asistencia_alumno_id')
                  ->constrained('asistencia_alumnos')
                  ->onDelete('restrict');

            // Motivo que escribe el alumno
            $table->text('motivo');

            // Estado del trámite administrativo
            $table->enum('estado', ['pendiente', 'aprobado', 'rechazado'])
                  ->default('pendiente');

            // (Opcional pero recomendado)
            // Fecha en que se resolvió la justificación
            $table->timestamp('fecha_resolucion')->nullable();

            $table->timestamps();

            // Solo puede existir una justificación por asistencia
            $table->unique('asistencia_alumno_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('justificaciones');
    }
};