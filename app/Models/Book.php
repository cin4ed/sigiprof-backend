<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'libros';

    protected $fillable = [
        'isbn',
        'doi',
        'titulo',
        'anio_publicacion',
        'editorial',
        'pais',
        'idioma',
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
