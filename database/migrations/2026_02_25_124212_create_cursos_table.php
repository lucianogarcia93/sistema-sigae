<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('nivel_id')
                  ->constrained('niveles')
                  ->restrictOnDelete();

            $table->string('division'); // A, B, C...
            $table->string('turno'); // mañana, tarde, noche

            $table->boolean('activo')->default(true);

            $table->timestamps();

            $table->unique(['nivel_id', 'division', 'turno']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cursos');
    }
};
