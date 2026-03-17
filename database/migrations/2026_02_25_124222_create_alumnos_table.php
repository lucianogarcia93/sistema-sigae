<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alumnos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('curso_id')
                  ->constrained('cursos')
                  ->restrictOnDelete();

            $table->string('nombre');
            $table->string('apellido');
            $table->string('email');
            $table->string('dni')->unique();
            $table->date('fecha_nacimiento')->nullable();

            // NUEVOS CAMPOS
            $table->integer('anio'); // año del alumno
            $table->string('estado')->default('pendiente'); // pendiente / aprobado / rechazado

            $table->boolean('activo')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alumnos');
    }
};