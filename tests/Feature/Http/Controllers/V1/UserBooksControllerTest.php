<?php

namespace Tests\Feature\Http\Controllers\V1;

use App\Models\Book;
use App\Models\User;

it('allows to list all books for a user', function () {
    $user = User::factory()->create();

    $user->books()->saveMany(Book::factory()->count(3)->make());

    $response = $this->actingAs($user)->getJson('/api/v1/user/books');

    $response->assertOk();
    $response->assertJsonCount(3);
});

it('allows to create books for a user', function () {
    $book = [
        'isbn' => '9783161484100',
        'doi' => '10.1234/abc',
        'titulo' => 'Libro de prueba',
        'anio_publicacion' => 2021,
        'editorial' => 'Editorial de prueba',
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
        'estado_publicacion' => 'PLANEACION',
    ];

    $user = User::factory()->create();

    $response = $this->actingAs($user)->postJson('/api/v1/user/books', $book);

    $response->assertCreated();
});
