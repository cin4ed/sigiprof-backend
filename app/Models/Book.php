<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $table = 'libros';

    protected $fillable = [
        'isbn',
        'doi',
        'titulo',
        'anio_publicacion',
        'editorial',
        'pais',
        'idioma',
        'recibio_apoyo_conahcyt',
        'programa_conahcyt',
        'esta_dictaminado',
        'url_cita',
        'cita_a',
        'cita_b',
        'total_citas',
        'estado_publicacion',
    ];

    /**
     * Get the users for the book.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'libros_usuarios', 'libro_id', 'usuario_id')
            ->withPivot('rol')
            ->withTimestamps();
    }
}
