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
        Schema::table('asistencia_alumnos', function (Blueprint $table) {
            // 🔹 Agrega el campo 'anio' después de 'fecha', permite null para no romper registros existentes
            $table->integer('anio')->after('fecha')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asistencia_alumnos', function (Blueprint $table) {
            $table->dropColumn('anio');
        });
    }
};