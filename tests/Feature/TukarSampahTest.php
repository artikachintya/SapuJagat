<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TukarSampahTest extends TestCase
{
    /** @test */
    public function user_can_access_tukar_sampah_page()
    {
        $user = User::create([
            'name' => 'Jhon Doe',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 1
        ]);

        $response = $this->actingAs($user)->get('/pengguna/tukar-sampah');

        $response->assertStatus(200);
        $response->assertSee('Tukar Sampah');
    }
}
