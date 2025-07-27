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

    protected $user;

    /** @test */
    public function menampilkan_belum_ada_pesanan_untuk_pertama_kali()
    {
        $this->user = User::create([
            'name' => 'Driver1',
            'email' => 'driver1@example.com',
            'password' => bcrypt('password'),
            'role' => 1
        ]);

        $response = $this->actingAs($this->user)->get('/pengguna/pelacakan');

        $response->assertStatus(200);
        $response->assertSee('Belum ada Pesanan');
        $response->assertSee('Silahkan buat pesanan terlebih dahulu untuk melacak prosesnya');
    }

    /** @test */
    public function user_can_access_penjemputan_page()
    {
        $this->user = User::create([
            'name' => 'Jhon Doe',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 1
        ]);

        $response = $this->actingAs($this->user)->get('/pengguna/pelacakan');

        $response->assertStatus(200);
    }
}
