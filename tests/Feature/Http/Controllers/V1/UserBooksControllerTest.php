<?php

namespace Tests\Feature\Http\Controllers\V1;

use App\Helpers\LibroEstados;
use App\Helpers\LibroUsuarioRoles;
use App\Models\Book;
use App\Models\User;

test('el usuario puede obtener todos los libros asociados a su perfil', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $books = Book::factory()->count(3)->create();
    $user->books()->attach($books);

    $response = $this->getJson('/api/v1/user/books');

    $response->assertStatus(200);
    $response->assertJsonCount(3);
});

test('el usuario puede crear un libro con multiples autores y asociarlo a su perfil', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $requestData = [
        'isbn' => '1234567890123',
        'doi' => '10.1234/book123',
        'titulo' => 'Libro de Prueba',
        'anio_publicacion' => 2023,
        'editorial' => 'Editorial de Prueba',
        'pais' => 'País de Prueba',
        'idioma' => 'Español',
        'rol_usuario_creador' => LibroUsuarioRoles::all()[0],
        'estado_publicacion' => LibroEstados::all()[0], // Use a valid state
        'autores' => [
            [
                'nombre' => 'Kenneth de Guadalupe',
                'primer_apellido' => 'Quintero',
                'segundo_apellido' => 'Valles',
                'orc_id' => '123456789',
                'orden' => 1
            ],
            [
                'nombre' => 'Victor Martín',
                'primer_apellido' => 'Rodríguez',
                'segundo_apellido' => 'Domínguez',
                'orc_id' => '987654321',
                'orden' => 2
            ]
        ]
    ];

    $response = $this->postJson('/api/v1/user/books', $requestData);

    $response->assertStatus(201);
    $book = Book::where('isbn', '1234567890123')->first();
    expect($book)->not->toBeNull();
    expect($book->authors)->toHaveCount(2);
    expect($book->authors[0]->nombre)->toBe('Kenneth de Guadalupe');
    expect($book->authors[1]->nombre)->toBe('Victor Martín');
});

test('no se puede crear un libro con autores que comparten el mismo orden', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $requestData = [
        'isbn' => '1234567890124',
        'doi' => '10.1234/book999',
        'titulo' => 'Libro con Orden Duplicado',
        'anio_publicacion' => 2023,
        'editorial' => 'Editorial de Prueba',
        'pais' => 'País de Prueba',
        'idioma' => 'Español',
        'rol_usuario_creador' => LibroUsuarioRoles::all()[0],
        'estado_publicacion' => LibroEstados::all()[0],
        'autores' => [
            [
                'nombre' => 'Autor Uno',
                'primer_apellido' => 'Apellido Uno',
                'segundo_apellido' => 'Apellido Dos',
                'orc_id' => '123456789',
                'orden' => 1
            ],
            [
                'nombre' => 'Autor Dos',
                'primer_apellido' => 'Apellido Tres',
                'segundo_apellido' => 'Apellido Cuatro',
                'orc_id' => '987654321',
                'orden' => 1 // Duplicate order value
            ]
        ]
    ];

    $response = $this->postJson('/api/v1/user/books', $requestData);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['autores.*.orden']);
});