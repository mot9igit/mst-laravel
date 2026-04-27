<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            "name" => "admin",
            "fullname" => "Петропавловский Артем",
            "active" => 1,
            "sudo" => 1,
            "email" => "artpetropavlovskij@gmail.com",
            "phone" => "+79991158355",
            "password" => '05061992'
        ]);
    }
}
