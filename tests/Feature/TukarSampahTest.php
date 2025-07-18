<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TukarSampahTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    /** @test */
    public function user_can_access_tukar_sampah_page()
    {
        $this->user = User::create([
            'name' => 'Jhon Doe',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 1
        ]);

        $response = $this->actingAs($this->user)->get('/pengguna/tukar-sampah');

        $response->assertStatus(200);
        $response->assertSee('Tukar Sampah');
    }

    /** @test */
    public function halaman_tukar_sampah_dapat_diakses_dan_menampilkan_data_sampah()
    {
        $this->user = User::create([
            'name' => 'Jhon Doe',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 1
        ]);

        $response = $this->actingAs($this->user)->get('/pengguna/tukar-sampah');

        $response->assertStatus(200);
        $response->assertSee('Pilih Sampah yang Ingin Ditukar');
        $response->assertSee('Organik');
        $response->assertSee('Anorganik');
        $response->assertSee('Lanjut');
    }
}
