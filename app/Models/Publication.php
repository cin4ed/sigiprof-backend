<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Publication extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'publicaciones';

    protected $fillable = [
        'issn_tipo',
        'issn_impreso',
        'issn_electronico',
        'doi',
        'nombre_revista',
        'titulo',
        'anio_publicacion',
        'recibio_apoyo_conahcyt',
        'estatus',
        'objetivo',
        'url_cita',
        'cita_a',
        'cita_b',
        'total_citas',
        'eje_conahcyt',
        'programa_conahcyt',
    ];

    /**
     * Get the users for the publication.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'publicaciones_usuarios', 'publicacion_id', 'usuario_id')
            ->withPivot('rol')
            ->withTimestamps();
    }

    /**
     * Get the authors for the publication.
     */
    public function authors()
    {
        return $this->belongsToMany(Author::class, 'autores_publicaciones', 'publicacion_id', 'autor_id')
            ->withTimestamps();
    }
}
