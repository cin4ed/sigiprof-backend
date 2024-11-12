<?php

namespace App\Http\Controllers\V1;

use App\Helpers\LibroEstados;
use App\Helpers\LibroUsuarioRoles;
use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
        $validated = Validator::make($request->all(), [
            'isbn' => 'required|size:13|unique:libros,isbn',
            'doi' => 'required|string|unique:libros,doi',
            'titulo' => 'required|string',
            'anio_publicacion' => 'required|integer',
            'editorial' => 'required|string',
            'pais' => 'required|string',
            'idioma' => 'required|string',
            'rol_usuario_creador' => ['required', Rule::in(LibroUsuarioRoles::all())],
            'estado_publicacion' => ['required', Rule::in(LibroEstados::all())],
            'autores' => 'sometimes|array',
            'autores.*.nombre' => 'required|string|max:255',
            'autores.*.primer_apellido' => 'required|string|max:255',
            'autores.*.segundo_apellido' => 'required|string|max:255',
            'autores.*.orc_id' => 'required|string|max:255',
            'autores.*.orden' => 'required|integer',
        ])->after(function ($validator) {
            $autores = request('autores');
            if (is_array($autores)) {
                $ordenes = array_column($autores, 'orden');
                if (count($ordenes) !== count(array_unique($ordenes))) {
                    $validator->errors()->add('autores.*.orden', 'Dos autores no pueden compartir el mismo número de orden.');
                }
            }
        })->validate();

        $book = null;
    
        DB::transaction(function () use ($validated, &$book) {
            $book = auth()->user()->books()->create($validated);
    
            if (!empty($validated['autores'])) {
                $authors = collect($validated['autores'])->map(function ($authorData) {
                    return Author::firstOrCreate([
                        'nombre' => $authorData['nombre'],
                        'primer_apellido' => $authorData['primer_apellido'],
                        'segundo_apellido' => $authorData['segundo_apellido'],
                        'orc_id' => $authorData['orc_id'],
                    ]);
                });
    
                $authorIdsWithPivot = $authors->mapWithKeys(function ($author, $index) use ($validated) {
                    return [$author->id => ['orden' => $validated['autores'][$index]['orden']]];
                })->toArray();
    
                $book->authors()->sync($authorIdsWithPivot);
            }
        });
    
        return response()->json($book->load('authors'), 201);
    }
}
