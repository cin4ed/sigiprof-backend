<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Publication;
use Illuminate\Http\Request;

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
            'estatus' => 'required|in:PUBLICADO,ACEPTADO',
        ]);

        $publication = auth()->user()->publications()->create($validated);

        return $publication;
    }
}
