<?php

use App\Helpers\ConahcytProgramas;
use App\Helpers\LibroEstados;
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
        Schema::create('libros', function (Blueprint $table) {
            $table->id();
            $table->stirng('isbn', 13)->unique();
            $table->string('doi')->unique();
            $table->string('titulo');
            $table->integer('anio_publicacion');
            $table->string('editorial');
            $table->string('pais');
            $table->string('idioma');
            $table->boolean('recibio_apoyo_conahcyt');
            $table->enum('programa_conahcyt', ConahcytProgramas::all())->nullable();
            $table->boolean('esta_dictaminado');
            $table->string('url_cita');
            $table->integer('cita_a');
            $table->integer('cita_b');
            $table->integer('total_citas');
            $table->enum('estado_publicacion', LibroEstados::all());
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('libros', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
