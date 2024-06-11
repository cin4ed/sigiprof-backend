<?php

namespace Tests\Feature\Models;

use App\Models\Book;

it('can create a book', function () {
    $book = Book::factory()->create();

    expect($book->id)->toBe(1);
    expect($book->isbn)->toBeString();
    expect($book->doi)->toBeString();
    expect($book->titulo)->toBeString();
    expect($book->anio_publicacion)->toBeInt();
    expect($book->editorial)->toBeString();
    expect($book->pais)->toBeString();
    expect($book->idioma)->toBeString();
    expect($book->recibio_apoyo_conahcyt)->toBeBool();
    expect($book->programa_conahcyt)->toBeString();
    expect($book->esta_dictaminado)->toBeBool();
    expect($book->url_cita)->toBeString();
    expect($book->cita_a)->toBeInt();
    expect($book->cita_b)->toBeInt();
    expect($book->total_citas)->toBeInt();
    expect($book->estado_publicacion)->toBeString();
});
