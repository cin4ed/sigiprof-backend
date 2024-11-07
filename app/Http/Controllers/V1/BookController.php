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
class BookController extends Controller
{
    /**
     * Get all books
     *
     * This endpoint retrieves all books.
     *
     * @return Book[] A list of books
     */
    public function index()
    {
        return Book::all();
    }

    /**
     * Get a book
     *
     * This endpoint retrieves a book.
     *
     * @return Book The book
     */
    public function show(Book $book)
    {
        return $book;
    }

    /**
     * Update a book
     *
     * This endpoint updates a book.
     *
     * @return Book The updated book
     */
    public function update(Book $book, Request $request)
    {
        $validated = $request->validate([
            'isbn' => 'required|size:13|unique:libros,isbn,'.$book->id,
            'doi' => 'required|string|unique:libros,doi,'.$book->id,
            'titulo' => 'required|string',
            'anio_publicacion' => 'required|integer',
            'editorial' => 'required|string',
            'pais' => 'required|string',
            'idioma' => 'required|string',
            'estado_publicacion' => ['required', Rule::in(LibroEstados::all())],
        ]);

        $book->update($validated);

        return $book;
    }

    /**
     * Delete a book
     *
     * This endpoint deletes a book.
     *
     * @return Book The deleted book
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return $book;
    }
}
