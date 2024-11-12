<?php

namespace Tests\Feature\Models;

use App\Models\Book;
use App\Models\User;
use App\Models\Author;

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
    expect($book->estado_publicacion)->toBeString();
});

it('can create a book for a user', function () {
    $book = Book::factory()->create();
    $user = User::factory()->create();

    $book->users()->attach($user, ['rol' => 'AUTOR']);

    expect($book->users->first()->id)->toBe($user->id);
    expect($book->users->first()->pivot->rol)->toBe('AUTOR');
});

it('permite asociar multiples autores a un libro', function () {
    $book = Book::factory()->create();
    $authors = Author::factory()->count(3)->create();

    $syncData = $authors->mapWithKeys(function ($author, $index) {
        return [$author->id => ['orden' => $index + 1]];
    })->toArray();

    $book->authors()->sync($syncData);

    expect($book->authors)->toHaveCount(3);
});