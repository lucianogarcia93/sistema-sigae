<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeriadosTable extends Migration
{
    public function up()
    {
        Schema::create('feriados', function (Blueprint $table) {
            $table->id();

            // Describe el evento (feriado o motivo de suspensión)
            $table->string('descripcion');

            // Fecha del día sin actividad
            $table->date('fecha')->unique();

            // Tipo: feriado oficial o día sin clases
            $table->enum('tipo', ['feriado', 'sin_clases'])->default('feriado');

            // Permite activar/desactivar sin borrar
            $table->boolean('activo')->default(true);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('feriados');
    }
}