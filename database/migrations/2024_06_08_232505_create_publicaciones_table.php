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
        Schema::create('publicaciones', function (Blueprint $table) {
            $table->id();
            $table->enum('issn_tipo', ['IMPRESO', 'ELECTRONICO', 'AMBOS']);
            $table->char('issn_impreso', 8)->unique()->nullable();
            $table->char('issn_electronico', 8)->unique()->nullable();
            $table->string('doi')->unique();
            $table->string('nombre_revista');
            $table->string('titulo');
            $table->integer('anio_publicacion');
            $table->enum('estatus', ['PUBLICADO', 'ACEPTADO']);
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
