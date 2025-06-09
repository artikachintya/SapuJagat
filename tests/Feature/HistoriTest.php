<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HistoriTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function user_can_access_histori(): void
    {
        $response = $this->get('/pengguna/histori');
        $response->assertStatus(302);

        $response->assertSee('Daftar Histori');
        $response->assertSee('Lihat Detail');
    }
}
