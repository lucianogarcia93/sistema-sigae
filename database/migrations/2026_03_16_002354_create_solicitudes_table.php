<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('curso_id');
            $table->string('nombre', 255);
            $table->string('apellido', 255);
            $table->string('dni', 20)->unique();
            $table->string('email', 255);
            $table->integer('anio');
            $table->date('fecha_nacimiento')->nullable();

            $table->enum('estado', ['pendiente', 'aprobado', 'rechazado'])->default('pendiente');

            // 🔥 NUEVOS CAMPOS
            $table->string('token', 100)->unique();
            $table->string('password_temporal', 100)->nullable(); // Contraseña para mostrar al alumno
            $table->text('motivo_rechazo')->nullable();

            $table->timestamps();

            $table->foreign('curso_id')
                ->references('id')
                ->on('cursos')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('solicitudes');
    }
};