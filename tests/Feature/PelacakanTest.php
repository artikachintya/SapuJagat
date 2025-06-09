<?php

namespace Tests\Feature;

use GuzzleHttp\Psr7\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PelacakanTest extends TestCase
{
    /** @test */
    public function user_can_see_ringkasan_pesanan(): void
    {
        $response = $this->get('/prngguna/ringkasan-pesanan');
        $response->assertStatus(302);

        $response->assertSee('Ringkasan Pesanan');
        $response->assertSee('Jemput');
        $response->assertSee('Nama Sampah');
        $response->assertSee('Kuantitas');
        $response->assertSee('Harga/Kg');
        $response->assertSee('Estimasi Total');
    }

    public function user_can_pickup(){
        $response = $this->post('/jemput', [
            'waktu_jemput' => '2023-10-01 10:00:00',
            'sampah' => [
                [
                    'nama_sampah' => 'Sisa Makanan',
                    'kuantitas' => 5,
                    'harga_per_kg' => 1000,
                    'estimasi_total' => 5000,
                ],
            ],
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/pengguna/pelacakan');
        
    }
}
