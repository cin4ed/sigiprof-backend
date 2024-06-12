<?php

namespace Tests\Feature\Http\Controllers\V1;

use App\Models\Book;
use App\Models\User;

it('allows to list all books', function () {
    $user = User::factory()->create();

    Book::factory()->count(3)->create();

    $response = $this->actingAs($user)->getJson('/api/v1/books');

    $response->assertOk();
});

it('allows to show a book', function () {
    $user = User::factory()->create();

    $book = Book::factory()->create();

    $response = $this->actingAs($user)->getJson("/api/v1/books/{$book->id}");

    $response->assertOk();
});

it('allows to update a book', function () {
    $user = User::factory()->create();

    $book = Book::factory()->create();

    $response = $this->actingAs($user)->putJson("/api/v1/books/{$book->id}", [
        'isbn' => '9783161484100',
        'doi' => '10.1000/182',
        'titulo' => 'The Book',
        'anio_publicacion' => 2021,
        'editorial' => 'Editorial',
        'pais' => 'México',
        'idioma' => 'Español',
        'recibio_apoyo_conahcyt' => true,
        'programa_conahcyt' => 'FONDO_INSTITUCIONAL',
        'esta_dictaminado' => true,
        'url_cita' => 'https://example.com',
        'cita_a' => 1,
        'cita_b' => 2,
        'total_citas' => 3,
        'eje_conahcyt' => 'DESARROLLO_TECNOLOGIAS',
        'estado_publicacion' => 'ENTREGADO',
    ]);

    $response->assertOk();
});
