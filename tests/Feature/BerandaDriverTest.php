<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BerandaDriverTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function halaman_pickup_order_dapat_diakses_driver()
    {
        $this->driver = User::create([
            'name' => 'driver1',
            'email' => 'driver1@example.com',
            'password' => Hash::make('password5'),
            'role' => 3,
        ]);
        $this->driver = User::create([
            'role' => 3,
            'name' => 'Admin1',
            'NIK' => '1234567890',
            'email' => 'old@example.com',
            'phone_num' => '08123456789',
            'password' => Hash::make('oldpassword'),
        ]);

        $response = $this->actingAs($this->driver)->get('/driver');
        $response->assertStatus(200);
        $response->assertSee('Daftar Pengambilan Pesanan');
    }
}
