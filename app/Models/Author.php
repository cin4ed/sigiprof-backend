<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'autores';

    protected $fillable = [
        'nombre',
        'primer_apellido',
        'segundo_apellido',
        'orc_id',
    ];

    /**
     * Get the publications for the author.
     */
    public function publications()
    {
        return $this->belongsToMany(Publication::class, 'autores_publicaciones', 'autor_id', 'publicacion_id')
            ->withTimestamps();
    }
}
