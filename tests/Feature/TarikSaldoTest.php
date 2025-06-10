<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TarikSaldoTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function user_can_access_tarik_saldo(): void
    {
        $response = $this->get('/pengguna/tarik-saldo');
        $response->assertStatus(302);
        $response->assertSee('Tarik Saldo Pengguna');
        $response->assertSee('Saldo');
        $response->assertSee('Nominal Penarikan');
        $response->assertSee('Tarik Dana');
    }

    public function user_can_create_tarik_saldo(): void
    {
        $response = $this->post('/pengguna/tarik-saldo', [
            'nominal' => 100000,
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/pengguna/tarik-saldo');
        $response->assertSessionHas('success', 'Permintaan penarikan saldo berhasil dibuat.');
    }
}
