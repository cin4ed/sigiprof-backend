<?php

namespace Tests\Feature\Http\Controllers\V1;

use App\Helpers\LibroEstados;
use App\Models\Book;
use App\Models\User;

it('permite listar todos los libros', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Book::factory()->count(3)->create();

    $response = $this->getJson('/api/v1/books');

    $response->assertOk();
    $response->assertJsonCount(3);
});

it('permite ver un libro específico', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $book = Book::factory()->create();

    $response = $this->getJson("/api/v1/books/{$book->id}");

    $response->assertOk();
    $response->assertJsonFragment([
        'id' => $book->id,
        'titulo' => $book->titulo,
    ]);
});

it('permite actualizar un libro con datos válidos', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $book = Book::factory()->create([
        'isbn' => '1234567890123',
        'doi' => '10.1234/book123',
        'titulo' => 'Libro Original',
        'anio_publicacion' => 2021,
        'editorial' => 'Editorial Original',
        'pais' => 'País Original',
        'idioma' => 'Español',
        'estado_publicacion' => LibroEstados::all()[0],
    ]);

    $updatedData = [
        'isbn' => '9876543210123',
        'doi' => '10.5678/book456',
        'titulo' => 'Libro Actualizado',
        'anio_publicacion' => 2022,
        'editorial' => 'Editorial Actualizada',
        'pais' => 'País Actualizado',
        'idioma' => 'Inglés',
        'estado_publicacion' => LibroEstados::all()[1], // Estado válido
    ];

    $response = $this->putJson("/api/v1/books/{$book->id}", $updatedData);

    $response->assertOk();
    $response->assertJsonFragment($updatedData);
    $this->assertDatabaseHas('libros', $updatedData);
});

it('falla al actualizar un libro con datos inválidos', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $book = Book::factory()->create();

    $invalidData = [
        'isbn' => 'isbnInvalido', // Longitud inválida
        'doi' => '', // DOI requerido
        'anio_publicacion' => 'no_es_un_entero', // Dato inválido
        'estado_publicacion' => 'INVALIDO', // Estado inválido
    ];

    $response = $this->putJson("/api/v1/books/{$book->id}", $invalidData);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['isbn', 'doi', 'anio_publicacion', 'estado_publicacion']);
});

it('permite eliminar un libro (soft delete)', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $book = Book::factory()->create();

    $response = $this->deleteJson("/api/v1/books/{$book->id}");

    $response->assertOk();
    $this->assertSoftDeleted('libros', ['id' => $book->id]);
});

it('falla al intentar acceder a un libro eliminado', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $book = Book::factory()->create();
    $book->delete();

    $response = $this->getJson("/api/v1/books/{$book->id}");

    $response->assertStatus(404);
});
