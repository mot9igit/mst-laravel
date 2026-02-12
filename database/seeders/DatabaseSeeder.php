<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            "name" => "admin",
            "fullname" => "Петропавловский Артем",
            "active" => 1,
            "sudo" => 1,
            "email" => "artpetropavlovskij@gmail.com",
            "phone" => "+79991158355",
            "password" => Hash::make('05061992')
        ]);
    }
}
