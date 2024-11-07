<?php

namespace App\Http\Controllers\V1;

use App\Helpers\LibroEstados;
use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * @tags Books
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
            'estado_publicacion' => ['required', Rule::in(LibroEstados::all())],
        ]);

        $book = auth()->user()->books()->create($validated);

        return $book;
    }
}
