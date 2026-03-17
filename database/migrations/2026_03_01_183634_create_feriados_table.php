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

            $table->string('nombre');
            $table->date('fecha');

            // Permite desactivar sin borrar
            $table->boolean('activo')->default(true);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('feriados');
    }
}
