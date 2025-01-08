<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginTest extends TestCase
{
    public function test_login_successful()
    {
        // Crear un usuario activado con la contraseña codificada
        $user = User::factory()->create([
            'actived' => 1,
            'password' => Hash::make('secret'),
        ]);

        // Simular el inicio de sesión
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'secret',
        ]);

        // Afirmar redirección al dashboard
        $response->assertRedirect('home');
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_fails_with_incorrect_credentials()
    {
        // Crear un usuario
        $user = User::factory()->create([
            'password' => Hash::make('secret'),
        ]);

        // Simular inicio de sesión con credenciales incorrectas
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        // Afirmar que se regresa con errores
        $response->assertSessionHasErrors(['email' => 'Credenciales incorrectas']);
        $this->assertGuest();
    }

    public function test_login_fails_with_inactive_account()
    {
        // Crear un usuario no activado
        $user = User::factory()->create([
            'actived' => 0,
            'password' => Hash::make('secret'),
        ]);

        // Simular inicio de sesión con cuenta inactiva
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'secret',
        ]);

        // Afirmar que se regresa con error de cuenta no activada
        $response->assertSessionHasErrors(['email' => 'Tu cuenta aún no ha sido activada.']);
        $this->assertGuest();
    }
}
