<?php

namespace Tests\Feature;

use GuzzleHttp\Psr7\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LaporanTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function user_can_access_histori(): void
    {
        $response = $this->get('/pengguna/laporan');

        $response->assertStatus(302);

        $response->assertSee('Daftar Laporan');
        $response->assertSee(' Buat Laporan');
    }

    public function user_can_create_laporan(): void
    {
        $response = $this->post('/pengguna/laporan/create', [
            'Laporan' => 'Laporan Kerusakan',
            // 'foto' => UploadedFile::fake()->image('kerusakan.jpg'),
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/pengguna/laporan');
    }
}
