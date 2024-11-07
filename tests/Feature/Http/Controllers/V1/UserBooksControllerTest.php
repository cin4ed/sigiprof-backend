<?php

namespace Tests\Feature\Http\Controllers\V1;

use App\Helpers\LibroEstados;
use App\Models\Book;
use App\Models\User;

test('el usuario puede obtener todos sus libros', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    // Crear libros y asignarlos al usuario autenticado
    $books = Book::factory()->count(3)->create();
    $user->books()->attach($books);

    $response = $this->getJson('/api/v1/user/books');

    $response->assertOk();
    $response->assertJsonCount(3);
    $response->assertJsonFragment([
        'id' => $books[0]->id,
        'titulo' => $books[0]->titulo,
    ]);
});

test('el usuario no puede ver libros de otros usuarios', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $this->actingAs($user);

    // Crear libros y asignarlos solo al otro usuario
    $otherBooks = Book::factory()->count(2)->create();
    $otherUser->books()->attach($otherBooks);

    $response = $this->getJson('/api/v1/user/books');

    $response->assertOk();
    $response->assertJsonMissing(['id' => $otherBooks[0]->id]);
    $response->assertJsonMissing(['id' => $otherBooks[1]->id]);
});

test('el usuario puede crear un libro y asociarlo a su perfil', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $bookData = [
        'isbn' => '1234567890123',
        'doi' => '10.1234/book123',
        'titulo' => 'Libro de Prueba',
        'anio_publicacion' => 2023,
        'editorial' => 'Editorial de Prueba',
        'pais' => 'País de Prueba',
        'idioma' => 'Español',
        'estado_publicacion' => LibroEstados::all()[0], // Use a valid state
    ];

    $response = $this->postJson('/api/v1/user/books', $bookData);

    $response->assertStatus(201); // Created
    $response->assertJsonFragment($bookData);

    // Verificar que el libro está en la base de datos y asociado al usuario
    $this->assertDatabaseHas('libros', ['isbn' => $bookData['isbn'], 'doi' => $bookData['doi']]);
    $this->assertDatabaseHas('libros_usuarios', ['usuario_id' => $user->id, 'libro_id' => Book::where('isbn', '1234567890123')->first()->id]);
});

test('falla al crear un libro si el ISBN o DOI no es único', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Book::factory()->create([
        'isbn' => '1234567890123',
        'doi' => '10.1234/book123',
    ]);

    $duplicateData = [
        'isbn' => '1234567890123', // No es único
        'doi' => '10.1234/book123', // No es único
        'titulo' => 'Libro Duplicado',
        'anio_publicacion' => 2023,
        'editorial' => 'Otra Editorial',
        'pais' => 'Otro País',
        'idioma' => 'Inglés',
        'estado_publicacion' => LibroEstados::all()[1], // Valid state
    ];

    $response = $this->postJson('/api/v1/user/books', $duplicateData);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['isbn', 'doi']);
});

test('un usuario sin autenticación no puede crear ni ver libros', function () {
    $bookData = [
        'isbn' => '1234567890123',
        'doi' => '10.1234/book123',
        'titulo' => 'Libro No Autenticado',
        'anio_publicacion' => 2023,
        'editorial' => 'Editorial de Prueba',
        'pais' => 'País de Prueba',
        'idioma' => 'Español',
        'estado_publicacion' => LibroEstados::all()[2], // Valid state
    ];

    $responseIndex = $this->getJson('/api/v1/user/books');
    $responseStore = $this->postJson('/api/v1/user/books', $bookData);

    $responseIndex->assertStatus(401); // No autorizado
    $responseStore->assertStatus(401); // No autorizado
});

test('el usuario puede crear un libro con un estado válido', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $bookData = [
        'isbn' => '1234567890123',
        'doi' => '10.1234/book123',
        'titulo' => 'Libro de Prueba',
        'anio_publicacion' => 2023,
        'editorial' => 'Editorial de Prueba',
        'pais' => 'País de Prueba',
        'idioma' => 'Español',
        'estado_publicacion' => LibroEstados::all()[0], // Use a valid state
    ];

    $response = $this->postJson('/api/v1/user/books', $bookData);

    $response->assertStatus(201); // Created
    $response->assertJsonFragment($bookData);

    // Verify the book exists in the database and is associated with the user
    $book = Book::where('isbn', '1234567890123')->first();
    $this->assertDatabaseHas('libros', ['isbn' => $bookData['isbn'], 'doi' => $bookData['doi']]);
    $this->assertDatabaseHas('libros_usuarios', ['usuario_id' => $user->id, 'libro_id' => $book->id]);
});

test('falla al crear un libro con un estado no válido', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $invalidData = [
        'isbn' => '1234567890123',
        'doi' => '10.1234/book123',
        'titulo' => 'Libro de Prueba',
        'anio_publicacion' => 2023,
        'editorial' => 'Editorial de Prueba',
        'pais' => 'País de Prueba',
        'idioma' => 'Español',
        'estado_publicacion' => 'INVALIDO', // Invalid state
    ];

    $response = $this->postJson('/api/v1/user/books', $invalidData);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['estado_publicacion']);
});
