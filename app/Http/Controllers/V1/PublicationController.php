<?php

namespace App\Http\Controllers\V1;

use App\Helpers\ConahcytProgramas;
use App\Http\Controllers\Controller;
use App\Models\Publication;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PublicationController extends Controller
{
    public function index()
    {
        return Publication::all();
    }

    public function show(Publication $publication)
    {
        return $publication;
    }

    public function update(Publication $publication, Request $request)
    {
        $validated = $request->validate([
            'issn_tipo' => 'required|in:impreso,electrónico,ambos',
            'issn_impreso' => 'required_if:issn_tipo,impreso|nullable|size:8|unique:publicaciones,issn_impreso,'.$publication->id,
            'issn_electronico' => 'required_if:issn_tipo,electrónico|nullable|size:8|unique:publicaciones,issn_electronico,'.$publication->id,
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
            'programa_conahcyt' => ['required', Rule::in(ConahcytProgramas::all())],
        ]);

        $publication->update($validated);

        return $publication;
    }

    public function destroy(Publication $publication)
    {
        $publication->delete();

        return response()->json(null, 204);
    }
}
