<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TukarSampahTest extends TestCase
{
    /** @test */
    public function Add(): void
    {
        $response = $this->get('/pengguna/tukar-sampah');

        $response->assertStatus(200);
        $response->assertSee('Sisa Makanan');
        $response->assertSee('Kulit Buah');
        $response->assertSee('Daun Kering');
        $response->assertSee('Kotoran Hewan');
        $response->assertSee('Cangkang Telur');
        $response->assertSee('Botol Plastik');
        $response->assertSee('Kaleng');
        $response->assertSee('Kardus');
        $response->assertSee('Kaca Pecah');
        $response->assertSee('Styrofoam');
    }

    public function user_can_tukar_sampah()
    {
        $response = $this->post('/pengguna/tukar-sampah', [
            'sampah' => [
                'sisa_makanan' => 2,
                'kulit_buah' => 1,
                'daun_kering' => 3,
            ]
        ]);
        $response->assertStatus(302);
        $this->get('/pengguna/ringkasan-pesanan')->assertStatus(200);
    }
}
