<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        // Test rejestracji jako klient
        $response = $this->post('/register', [
            'name' => 'Test Client',
            'email' => 'client@example.com',
            'role' => 'client',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('client.dashboard', absolute: false));

        // Wylogowanie, aby przetestować następnego użytkownika
        $this->post('/logout');

        // Test rejestracji jako usługodawca
        $response = $this->post('/register', [
            'name' => 'Test Provider',
            'email' => 'provider@example.com',
            'role' => 'provider',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('provider.dashboard', absolute: false));

        // Wylogowanie, aby przetestować następnego użytkownika
        $this->post('/logout');

        // Test rejestracji jako administrator
        $response = $this->post('/register', [
            'name' => 'Test Admin',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('admin.dashboard', absolute: false));
    }

}
