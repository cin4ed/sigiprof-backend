<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Course;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Publication;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a bunch of users
        User::factory()->create([
            'nombre' => "Victor Martín",
            'primer_apellido' => "Rodríguez",
            'segundo_apellido' => "Domínguez",
            'image_url' => 'https://avatar.iran.liara.run/public/9',
            'email' => 'victor.rodriguez@email.com',
            'password' => Hash::make('secret'),
        ]);

        User::factory()->create([
            'nombre' => "Jorge",
            'primer_apellido' => "Barajas",
            'segundo_apellido' => "Mayer",
            'image_url' => 'https://avatar.iran.liara.run/public/1',
            'email' => 'jorge.barajas@email.com',
            'password' => Hash::make('secret'),
        ]);

        User::factory()->create([
            'nombre' => "Jose Hiram",
            'primer_apellido' => "López",
            'segundo_apellido' => "Camacho",
            'image_url' => 'https://avatar.iran.liara.run/public/12',
            'email' => 'hiram.lopez@email.com',
            'password' => Hash::make('secret'),
        ]);

        User::factory()->create([
            'nombre' => "Kenneth",
            'primer_apellido' => "Quintero",
            'segundo_apellido' => "Valles",
            'image_url' => 'https://avatar.iran.liara.run/public/46',
            'email' => 'kenneth.quintero@email.com',
            'password' => Hash::make('secret'),
        ]);

        // Create a token for the user (this will be used in the api documentation)
        // $token = new PersonalAccessToken;
        // $token->name = 'admin-token';
        // $token->token = hash('sha256', $plainTextToken = env('ADMIN_API_TOKEN'));
        // $token->abilities = ['*']; // Or specify abilities
        // $token->tokenable_id = $admin->id;
        // $token->tokenable_type = User::class;
        // $token->save();

        // // Create 10 publications for the user
        // $admin->publications()->saveMany(Publication::factory(10)->make());

        // // Create 10 courses for the user
        // $admin->courses()->saveMany(Course::factory(10)->make());

        // // Create 10 books for the user
        // $admin->books()->saveMany(Book::factory(10)->make());
    }
}
