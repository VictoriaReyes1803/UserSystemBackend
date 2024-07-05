<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use App\Models\User;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    
     public function test_login_with_valid_credentials()
     {
         $user = User::factory()->create([
             'email' => 'user@example.com',
             'password' => bcrypt($password = 'password'),
         ]);
 
         $response = $this->postJson('/api/auth/login', [
             'email' => 'user@example.com',
             'password' => $password,
         ]);
 
         $response->assertStatus(200)
                  ->assertJsonStructure(['data' => ['access_token']]);
     }
 
     public function test_login_with_invalid_credentials()
     {
         $user = User::factory()->create([
             'email' => 'user@example.com',
             'password' => bcrypt('password'),
         ]);
 
         $response = $this->postJson('/api/auth/login', [
             'email' => 'user@example.com',
             'password' => 'wrongpassword',
         ]);
 
         $response->assertStatus(401)
                  ->assertJson(['error' => 'Unauthorized']);
     }
 
     public function test_logout()
     {
         $user = User::factory()->create();
         //log::info($user);
 
         $token = auth('api')->login($user);
        // log::info($token);
 
         $response = $this->postJson('/api/auth/logout', [
             'Authorization' => "Bearer $token",
         ]);
 
         $response->assertStatus(200)
                  ->assertJson(['message' => 'Successfully logged out']);
     }
 
     public function test_me()
     {
         $user = User::factory()->create();
 
         $token = auth('api')->login($user);
 
         $response = $this->getJson('/api/auth/me', [
             'Authorization' => "Bearer $token",
         ]);
 
         $response->assertStatus(200)
             ->assertJson([
                 'id' => $user->id,
                 'name' => $user->name,
                 'lastname' => $user->lastname,
                 'email' => $user->email,

             ]);
     }
}
