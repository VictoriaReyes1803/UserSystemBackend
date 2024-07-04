<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    public function test_index_returns_all_users()
    {
        User::factory()->count(4)->create();
        $response = $this->actingAs(User::factory()->create(), 'api')->get('/api/auth/index');
        //log::info($response->getContent());
        $response->assertStatus(200);
        $response->assertJsonCount(5);
    }

    public function test_create_creates_a_new_user()
    {
        $user = User::factory()->create();
        $userData = [
            'name' => 'John',
            'lastname' => 'Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password',
        ];

        $response = $this->actingAs($user, 'api')->post('api/create', $userData);

        $response->assertStatus(201);
        $response->assertJson(['data' => 'Usuario creado exitosamente.']);
        $this->assertDatabaseHas('users', ['email' => 'johndoe@example.com']);
    }

    public function test_update_updates_an_existing_user()
    {
        $user = User::factory()->create();
        $updateData = [
            'name' => 'Jane',
            'lastname' => 'Doe',
            'email' => 'janedoe@example.com',
        ];

        $response = $this->actingAs($user, 'api')->put("/api/auth/update/{$user->id}", $updateData);

        $response->assertStatus(200);
        $response->assertJson(['data' => 'User updated successfully.']);
        $this->assertDatabaseHas('users', ['email' => 'janedoe@example.com']);
    }

    public function test_destroy_deletes_an_existing_user()
    {
        $user = User::factory()->create();
        log::info($user);
        $response = $this->actingAs($user, 'api')->delete("/api/auth/delete/{$user->id}");
        log::info($response->getContent());

        $response->assertStatus(200);
        $response->assertJson(['message' => 'User deleted successfully.']);
        $this->assertDatabaseHas('users', ['id' => $user->id, 'deleted_at' => now()]);
    }

    public function test_unauthenticated_user_cannot_access_protected_routes()
    {
        $response = $this->get('/api/auth/index');

        $response->assertStatus(401);
        $response->assertJson(['message' => 'Unauthenticated.']);
    }
}
