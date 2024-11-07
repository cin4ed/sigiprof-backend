<?php

namespace Tests\Feature;

use function Pest\Laravel\get;

test('the home page loads', function () {
    $this->get('/')->assertOk();
});

test('the home page really works')->get('/')->assertOk();

get('/')->assertOk();
