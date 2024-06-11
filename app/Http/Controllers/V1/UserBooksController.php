<?php

namespace App\Http\Controllers\V1;

use App\Helpers\ConahcytProgramas;
use App\Helpers\LibroEstados;
use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * @tags Book
 */
class UserBooksController extends Controller
{
    /**
     * Get all books for current user
     *
     * This endpoint retrieves all books that are associated with the
     *
     * @return Book[] A list of books
     */
    public function index()
    {
        return auth()->user()->books;
    }

    /**
     * Create a new book for current user
     *
     * This endpoint creates a new book for the authenticated user.
     *
     * @return Book The created book
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'isbn' => 'required|size:13|unique:libros,isbn',
            'doi' => 'required|string|unique:libros,doi',
            'titulo' => 'required|string',
            'anio_publicacion' => 'required|integer',
            'editorial' => 'required|string',
            'pais' => 'required|string',
            'idioma' => 'required|string',
            'recibio_apoyo_conahcyt' => 'required|boolean',
            'programa_conahcyt' => ['required_if:recibio_apoyo_conahcyt,true', 'nullable', Rule::in(ConahcytProgramas::all())],
            'esta_dictaminado' => 'required|boolean',
            'url_cita' => 'required|url',
            'cita_a' => 'required|integer',
            'cita_b' => 'required|integer',
            'total_citas' => 'required|integer',
            'eje_conahcyt' => 'required|in:DESARROLLO_TECNOLOGIAS,DIFUSION_CIENCIA,FORTALECIMIENTO_COMUNIDAD,IMPULSO_FRONTERAS,INCIDENCIA_PROBLEMATICAS',
            'estado_publicacion' => ['required', Rule::in(LibroEstados::all())],
        ]);

        $book = auth()->user()->books()->create($validated);

        return $book;
    }
}
