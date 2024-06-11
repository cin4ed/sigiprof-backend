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
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo_formacion', ['ACREDITACION', 'CERTIFICACION', 'COACHING', 'CURSO', 'DIPLOMADO', 'SEMINARIO', 'TALLER']);
            $table->string('nombre');
            $table->integer('anio');
            $table->integer('horas_totales');
            $table->string('institucion');
            $table->enum('tipo_institucion', ['EXTRANJERA', 'NACIONAL']);
            $table->enum('modalidad_institucion', ['PUBLICA_FEDERAl', 'PUBLICA_ESTATAL', 'PUBLICA_MUNICIPAL', 'PRIVADA']);
            $table->text('descripcion');
            $table->foreignId('usuario_id')->constrained('usuarios')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cursos', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
