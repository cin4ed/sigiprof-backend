<?php

namespace Tests\Feature\Models;

use App\Models\Publication;
use App\Models\User;

it('can create a publication for a user', function () {
    $publication = Publication::factory()->create();
    $user = User::factory()->create();

    $user->publications()->attach($publication, ['rol' => 'AUTOR']);

    expect($user->publications->first()->id)->toBe($publication->id);
    expect($user->publications->first()->pivot->rol)->toBe('AUTOR');
});

it('can create a book for a user', function () {
    $book = Publication::factory()->create();
    $user = User::factory()->create();

    $user->publications()->attach($book, ['rol' => 'AUTOR']);

    expect($user->publications->first()->id)->toBe($book->id);
    expect($user->publications->first()->pivot->rol)->toBe('AUTOR');
});

it('can create a course for a user', function () {
    $course = Publication::factory()->create();
    $user = User::factory()->create();

    $user->publications()->attach($course, ['rol' => 'AUTOR']);

    expect($user->publications->first()->id)->toBe($course->id);
    expect($user->publications->first()->pivot->rol)->toBe('AUTOR');
});
