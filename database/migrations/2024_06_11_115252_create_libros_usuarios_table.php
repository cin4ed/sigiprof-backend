<?php

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
        Schema::create('libros_usuarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('libro_id')->constrained('libros');
            $table->foreignId('usuario_id')->constrained('usuarios');
            $table->enum('rol', LibroUsuarioRoles::all());
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('libros_usuarios', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
