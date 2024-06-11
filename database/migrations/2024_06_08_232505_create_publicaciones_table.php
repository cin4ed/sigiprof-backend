<?php

use App\Helpers\ConahcytProgramas;
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
        Schema::create('publicaciones', function (Blueprint $table) {
            $table->id();
            $table->enum('issn_tipo', ['impreso', 'electrónico', 'ambos']);
            $table->char('issn_impreso', 8)->unique()->nullable();
            $table->char('issn_electronico', 8)->unique()->nullable();
            $table->string('doi')->unique();
            $table->string('nombre_revista');
            $table->string('titulo');
            $table->integer('anio_publicacion');
            $table->boolean('recibio_apoyo_conahcyt');
            $table->enum('estatus', ['PUBLICADO', 'ACEPTADO']);
            $table->enum('objetivo', ['INVESTIGACION', 'TRABAJO_DIFUSION', 'LIBROS_DOCENCIA']);
            $table->string('url_cita');
            $table->integer('cita_a');
            $table->integer('cita_b');
            $table->integer('total_citas');
            $table->enum('eje_conahcyt', ['DESARROLLO_TECNOLOGIAS', 'DIFUSION_CIENCIA', 'FORTALECIMIENTO_COMUNIDAD', 'IMPULSO_FRONTERAS', 'INCIDENCIA_PROBLEMATICAS']);
            $table->enum('programa_conahcyt', ConahcytProgramas::all());
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('publicaciones', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
