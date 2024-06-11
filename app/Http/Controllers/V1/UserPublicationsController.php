<?php

namespace App\Http\Controllers\V1;

use App\Helpers\ConahcytProgramas;
use App\Http\Controllers\Controller;
use App\Models\Publication;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * @tags Publications
 */
class UserPublicationsController extends Controller
{
    /**
     * Get all publications for current user
     *
     * This endpoint retrieves all publications that are associated with the
     * authenticated user.
     *
     * @return Publication[] A list of publications
     */
    public function index()
    {
        return auth()->user()->publications;
    }

    /**
     * Create a new publication for current user
     *
     * This endpoint creates a new publication for the authenticated user.
     *
     * @return Publication The created publication
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'issn_tipo' => 'required|in:IMPRESO,ELECTRONICO,AMBOS',
            'issn_impreso' => 'required_if:issn_tipo,IMPRESO|nullable|size:8|unique:publicaciones,issn_impreso',
            'issn_electronico' => 'required_if:issn_tipo,ELECTRONICO|nullable|size:8|unique:publicaciones,issn_electronico',
            'doi' => 'required|string|unique:publicaciones,doi',
            'nombre_revista' => 'required|string',
            'titulo' => 'required|string',
            'anio_publicacion' => 'required|integer',
            'recibio_apoyo_conahcyt' => 'required|boolean',
            'estatus' => 'required|in:PUBLICADO,ACEPTADO',
            'objetivo' => 'required|in:INVESTIGACION,TRABAJO_DIFUSION,LIBROS_DOCENCIA',
            'url_cita' => 'required|url',
            'cita_a' => 'required|integer',
            'cita_b' => 'required|integer',
            'total_citas' => 'required|integer',
            'eje_conahcyt' => 'required|in:DESARROLLO_TECNOLOGIAS,DIFUSION_CIENCIA,FORTALECIMIENTO_COMUNIDAD,IMPULSO_FRONTERAS,INCIDENCIA_PROBLEMATICAS',
            'programa_conahcyt' => ['required_if:recibio_apoyo_conahcyt,true', 'nullable', Rule::in(ConahcytProgramas::all())],
        ]);

        $publication = auth()->user()->publications()->create($validated);

        return $publication;
    }
}
