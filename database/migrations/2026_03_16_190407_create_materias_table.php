<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('materias', function (Blueprint $table) {

            $table->id();

            $table->string('nombre');
            $table->string('codigo')->unique()->nullable();

            $table->foreignId('profesor_id')
                  ->constrained('profesores')
                  ->restrictOnDelete();
                  
            $table->boolean('activo')->default(true);

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materias');
    }
};
