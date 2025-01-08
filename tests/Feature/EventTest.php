<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Category;
use App\Models\Events;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class EventTest extends TestCase
{
    use RefreshDatabase;

    public function test_organizer_can_create_event()
    {
        $user = User::factory()->create(['role' => 'o']); // Crear un usuario organizador
        $category = Category::factory()->create(); // Crear una categoría

        $this->actingAs($user); // Actuar como el usuario organizador

        $eventData = [
            'title' => 'Evento de prueba',
            'description' => 'Descripción del evento',
            'organizer_id' => $user->id,
            'category_id' => $category->id, // Usar la categoría creada
            'start_time' => now(),
            'end_time' => now()->addHours(2),
            'location' => 'Lugar de prueba',
            'latitude' => 40.7128,
            'longitude' => -74.0060,
            'max_attendees' => 100,
            'price' => 50,
            'image_url' => null,
            'deleted' => 0,
        ];

        // Subir una imagen de prueba
        $response = $this->post(route('events.store'), $eventData);

        $this->assertDatabaseHas('events', $eventData); // Verifica que el evento ha sido creado
    }

    public function test_non_organizer_cannot_create_event()
    {
        $user = User::factory()->create(['role' => 'u']); // Crear un usuario no organizador
        $category = Category::factory()->create(); // Crear una categoría

        $this->actingAs($user); // Actuar como el usuario no organizador

        $eventData = [
            'title' => 'Evento de prueba',
            'description' => 'Descripción del evento',
            'category_id' => $category->id, // Usar la categoría creada
            'start_time' => now(),
            'end_time' => now()->addHours(2),
            'location' => 'Lugar de prueba',
            'latitude' => 40.7128,
            'longitude' => -74.0060,
            'max_attendees' => 100,
            'price' => 50,
        ];

        $response = $this->post(route('events.create'), $eventData);

        $response->assertRedirect(route('home')); // Asegúrate de que se redirige correctamente
        $this->assertDatabaseMissing('events', $eventData); // El evento no debe haberse creado
    }

    public function test_organizer_can_delete_own_event()
    {
        $organizer = User::factory()->create(['role' => 'o']); // Crear un organizador
        $category = Category::factory()->create(); // Crear una categoría
        $event = Events::factory()->create(['organizer_id' => $organizer->id, 'category_id' => $category->id]); // Crear un evento para el organizador

        $this->actingAs($organizer); // Actuar como el organizador

        $response = $this->delete(route('events.delete', ['event' => $event->id]));

        $this->assertDatabaseHas('events', ['id' => $event->id, 'deleted' => 1]); // El evento debe estar marcado como eliminado
    }

    public function test_organizer_cannot_delete_other_organizer_event()
    {
        $organizer1 = User::factory()->create(['role' => 'o']); // Crear el primer organizador
        $organizer2 = User::factory()->create(['role' => 'o']); // Crear un segundo organizador
        $category = Category::factory()->create(); // Crear una categoría

        $event = Events::factory()->create(['organizer_id' => $organizer1->id, 'category_id' => $category->id]); // Crear un evento para el organizador 1

        $this->actingAs($organizer2); // Actuar como el organizador 2 (no es dueño del evento)

        $response = $this->delete(route('events.delete', ['event' => $event->id]));

        $response->assertStatus(403); // El organizador 2 no debe poder eliminar el evento
        $this->assertDatabaseHas('events', ['id' => $event->id, 'deleted' => 0]); // El evento no debe haberse eliminado
    }

    public function test_admin_can_delete_event()
    {
        $admin = User::factory()->create(['role' => 'a']);
        $organizer = User::factory()->create(['role' => 'o']); // Crear un usuario no organizador
        $category = Category::factory()->create(); // Crear una categoría
        $event = Events::factory()->create(['organizer_id' => $organizer->id, 'category_id' => $category->id]); // Crear un evento con otro organizador

        $this->actingAs($admin); // Actuar como un usuario no organizador

        $response = $this->delete(route('events.delete', ['event' => $event->id]));

        $this->assertDatabaseHas('events', ['id' => $event->id, 'deleted' => 0]); // El evento no debe haberse eliminado
    }
}
