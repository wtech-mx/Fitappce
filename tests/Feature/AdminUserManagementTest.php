<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AdminUserManagementTest extends TestCase
{
    public function test_admin_can_create_a_client(): void
    {
        if (config('database.default') === 'sqlite' && ! extension_loaded('pdo_sqlite')) {
            $this->markTestSkipped('pdo_sqlite is not available in this PHP environment.');
        }

        $adminEmail = 'admin-test-'.uniqid().'@example.com';
        $clientEmail = 'cliente-test-'.uniqid().'@example.com';

        $admin = User::factory()->create([
            'role' => 'admin',
            'email' => $adminEmail,
        ]);

        try {
            $response = $this
                ->actingAs($admin)
                ->post('/admin/usuarios', [
                    'name' => 'Cliente Prueba',
                    'email' => $clientEmail,
                    'password' => 'Cliente12345',
                    'password_confirmation' => 'Cliente12345',
                    'phone' => '+52 555 000 0000',
                    'status' => 'active',
                    'goal' => 'Aumento de masa muscular',
                    'service' => 'Rutina + nutricion',
                    'plan_type' => 'Personalizado mensual',
                    'training_level' => 'Intermedio',
                    'training_days' => 4,
                    'training_place' => 'Gimnasio',
                    'initial_weight' => 72.5,
                ]);

            $client = User::where('email', $clientEmail)->first();

            $this->assertNotNull($client);
            $this->assertSame('user', $client->role);
            $this->assertSame('active', $client->status);
            $this->assertSame('72.50', $client->initial_weight);
            $response->assertRedirect(route('fitapp.admin.usuarios.detalle', $client));
        } finally {
            User::whereIn('email', [$adminEmail, $clientEmail])->delete();
        }
    }
}
