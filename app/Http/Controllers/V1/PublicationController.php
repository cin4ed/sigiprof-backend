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
class PublicationController extends Controller
{
    /**
     * Get all publications
     *
     * This endpoint retrieves all publications.
     *
     * @return Publication[] A list of publications
     */
    public function index()
    {
        return Publication::all();
    }

    /**
     * Create a new publication
     *
     * This endpoint creates a new publication.
     *
     * @return Publication The created publication
     */
    public function show(Publication $publication)
    {
        return $publication;
    }

    /**
     * Create a new publication
     *
     * This endpoint creates a new publication.
     *
     * @return Publication The created publication
     */
    public function update(Publication $publication, Request $request)
    {
        $validated = $request->validate([
            'issn_tipo' => 'required|in:IMPRESO,ELECTRONICO,AMBOS',
            'issn_impreso' => 'required_if:issn_tipo,IMPRESO|nullable|size:8|unique:publicaciones,issn_impreso,'.$publication->id,
            'issn_electronico' => 'required_if:issn_tipo,ELECTRONICO|nullable|size:8|unique:publicaciones,issn_electronico,'.$publication->id,
            'doi' => 'required|string|unique:publicaciones,doi,'.$publication->id,
            'nombre_revista' => 'required|string',
            'titulo' => 'required|string',
            'anio_publicacion' => 'required|integer',
            'estatus' => 'required|in:PUBLICADO,ACEPTADO',
        ]);

        $publication->update($validated);

        return $publication;
    }

    /**
     * Delete a publication
     *
     * This endpoint deletes a publication.
     *
     * @return void
     */
    public function destroy(Publication $publication)
    {
        $publication->delete();

        return response()->json(null, 204);
    }
}
