<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DasboardTest extends TestCase
{
    /** @test */ 
    public function user_can_access_dasboard()
    {
        $response = $this->get('/pengguna/dasboard');

        $this->get('/pengguna/tukar-sampah')->assertStatus(200)->assertSee('Tukar Sampah');
        $this->get('pengguna/histori')->assertStatus(200)->assertSee('Histori');
        // $this->get('/pengguna/pelacakan')->assertStatus(200)->assertSee('Pelacakan');
        $this->get('pengguna/laporan')->assertStatus(200)->assertSee('Laporan');
        $this->get('pengguna/tarik-saldo')->assertStatus(200)->assertSee('Tarik Saldo');
        
    }
}
