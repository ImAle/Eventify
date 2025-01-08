<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_successful_registration_without_image()
    {
        Notification::fake();

        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'u',
        ]);

        $response->assertRedirect('/home');
        $this->assertDatabaseHas('users', [
            'email' => 'johndoe@example.com',
            'name' => 'John Doe',
            'role' => 'u',
            'actived' => 0,
        ]);

        $user = User::where('email', 'johndoe@example.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals(0, $user->email_confirmed);
        $this->assertTrue(Hash::check('password123', $user->password));

        Notification::assertSentTo($user, \Illuminate\Auth\Notifications\VerifyEmail::class);
    }

    public function test_successful_registration_with_image()
    {
        Storage::fake('public');
        Notification::fake();

        $file = UploadedFile::fake()->image('profile.jpg');
        $response = $this->post('/register', [
            'name' => 'Jane Doe',
            'email' => 'janedoe@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'u',
            'profile_image' => $file,
        ]);

        $response->assertRedirect('/home');
        $this->assertDatabaseHas('users', [
            'email' => 'janedoe@example.com',
            'name' => 'Jane Doe',
        ]);

        $user = User::where('email', 'janedoe@example.com')->first();
        Storage::disk('public')->assertExists($user->profile_picture);
    }

    public function test_registration_fails_with_invalid_data()
    {
        $response = $this->post('/register', [
            'name' => '',
            'email' => 'invalid-email',
            'password' => 'short',
            'password_confirmation' => 'notmatching',
        ]);

        $response->assertSessionHasErrors(['name', 'email', 'password']);
        $this->assertDatabaseMissing('users', [
            'email' => 'invalid-email',
        ]);
    }

    public function test_registration_fails_if_email_already_registered()
    {
        User::factory()->create([
            'email' => 'duplicate@example.com',
        ]);

        $response = $this->post('/register', [
            'name' => 'Duplicate User',
            'email' => 'duplicate@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'u',
        ]);

        $response->assertSessionHasErrors(['email']);
    }
}
