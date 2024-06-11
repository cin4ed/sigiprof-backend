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
        Schema::create('autores', function (Blueprint $table) {
            $table->id();
            $table->string('primer_apellido');
            $table->string('segundo_apellido');
            $table->char('orc_id', 16);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('autores', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
