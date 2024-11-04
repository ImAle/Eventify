<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\User;
use \App\Models\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // Crear usuario administrador
        User::factory()->create([
            'name' => 'Administrador',
            'email' => 'admin@admin.com',
            'password' => bcrypt('12345678'),
            'role' => 'a',
            'actived' => 1, // Usuario activado
            'email_confirmed' => 1, // Email confirmado
        ]);

        // Crear otros usuarios si es necesario
        User::factory(10)->create();

        // Crear categorías
        $categories = [
            ['name' => 'Music', 'description' => 'All kinds of music events'],
            ['name' => 'Sports', 'description' => 'Sports related events'],
            ['name' => 'Tech', 'description' => 'Tech related events'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
