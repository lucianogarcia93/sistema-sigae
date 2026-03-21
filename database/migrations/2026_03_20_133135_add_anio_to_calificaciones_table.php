<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAnioToCalificacionesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('calificaciones', function (Blueprint $table) {
            $table->integer('anio')->nullable()->after('tipo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('calificaciones', function (Blueprint $table) {
            $table->dropColumn('anio');
        });
    }
}
