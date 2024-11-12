<?php

use App\Helpers\LibroEstados;
use App\Helpers\LibroUsuarioRoles;
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
            $table->string('isbn', 13)->unique();
            $table->string('doi')->unique();
            $table->string('titulo');
            $table->integer('anio_publicacion');
            $table->string('editorial');
            $table->string('pais');
            $table->string('idioma');
            $table->enum('rol_usuario_creador', LibroUsuarioRoles::all());
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
