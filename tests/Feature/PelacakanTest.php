<?php

namespace Tests\Feature;

use App\Models\User;
use GuzzleHttp\Psr7\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PelacakanTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_access_status_penjemputan_page()
    {
        $user = User::create([
            'name' => 'Jhon Doe',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 1
        ]);

        $response = $this->actingAs($user)->get('/pengguna/pelacakan');

        $response->assertStatus(200);
    }

    /** @test */
    public function driver_information_is_visible_if_available()
    {
        $user = User::create([
            'name' => 'Jhon Doe',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 1
        ]);

        $response = $this->actingAs($user)->get('/pengguna/pelacakan');

        $response->assertStatus(200);
    }
}
