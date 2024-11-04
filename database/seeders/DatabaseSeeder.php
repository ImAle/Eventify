<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\User;
use \App\Models\Category;
use \App\Models\Events;

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

        $organizer = User::factory()->create([
            'name' => 'organizador',
            'email' => 'organizador@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => 'o',
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

        foreach ($categories as $categoryData) {
            // Crear la categoría y obtener el objeto creado
            $category = Category::create($categoryData);

            // Crear un evento para cada categoría creada
            Events::create([
                'organizer_id' => $organizer->id,
                'title' => "Evento {$category->name}",
                'description' => "{$category-> description}.",
                'category_id' => $category->id,
                'start_time' => now()->addDays(rand(1, 30)),
                'end_time' => now()->addDays(rand(1, 30)), // Fecha aleatoria en los próximos 30 días
                'location' => 'Ciudad Central',
                'latitude' => '19.4326', // Coordenadas de ejemplo (Ciudad de México)
                'longitude' => '-99.1332',
                'max_attendees' => rand(50, 200),
                'price' => rand(10, 100) * 100, // Precio aleatorio entre $100 y $10,000
                'image_url' => 'https://via.placeholder.com/600', // URL de imagen de ejemplo
                'deleted' => false, // No eliminado
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        }


    }
}
