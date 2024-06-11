<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Publication;
use Illuminate\Http\Request;

/**
 * @tags Authors
 */
class PublicationAuthorsController extends Controller
{
    /**
     * Get all authors for a publication
     *
     * This endpoint allows you to get all authors for a publication.
     *
     * @return Author[] The authors for the publication
     */
    public function index(Publication $publication)
    {
        return $publication->authors;
    }

    /**
     * Create a new author for a publication
     *
     * This endpoint allows you to create a new author for a publication.
     *
     * @return Author The newly created author
     */
    public function store(Publication $publication, Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string',
            'primer_apellido' => 'required|string',
            'segundo_apellido' => 'required|string',
            'orc_id' => 'required|string|size:16',
        ]);

        $author = $publication->authors()->create($validated);

        return response()->json($author, 201);
    }
}
