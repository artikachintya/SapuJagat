<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HistoriUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function halaman_histori_dapat_diakses_dan_menampilkan_judul()
    {

        $user = User::create([
            'name' => 'Tester',
            'email' => 'tester@example.com',
            'password' => bcrypt('password'),
            'role' => 1,
        ]);

        $response = $this->actingAs($this->$user)->get('/user/histori');
        $response->assertStatus(200);
        $response->assertSee('Daftar Histori');
        $response->assertSee('Histori Penukaran Kreasi');
    }

    /** @test */
    public function histori_kosong_menampilkan_pesan_khusus()
    {
        $user = User::create([
            'name' => 'Tester',
            'email' => 'tester@example.com',
            'password' => bcrypt('password'),
            'role' => 1,
        ]);

        $response = $this->actingAs($this->$user)->get('/user/histori');
        $response->assertSee('Tidak ada histori penukaran tersedia.');
    }

    /** @test */
    public function pengguna_dapat_kembali_ke_dashboard_dari_histori()
    {
        $user = User::create([
            'name' => 'Tester',
            'email' => 'tester@example.com',
            'password' => bcrypt('password'),
            'role' => 1,
        ]);

        $response = $this->actingAs($this->$user)->get('/user/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Dashboard User');
    }

    /** @test */
    public function histori_muncul_jika_transaksi_ada()
    {
        $user = User::create([
            'name' => 'Tester',
            'email' => 'tester@example.com',
            'password' => bcrypt('password'),
            'role' => 1,
        ]);

        Order::factory()->create([
            'user_id' => $this->$user->id,
            'status' => 'Selesai',
            'nama_pengguna' => 'John Doe'
        ]);

        $response = $this->actingAs($this->$user)->get('/user/histori');
        $response->assertSee('Selesai');
        $response->assertSee('John');
    }

    /** @test */
    public function hanya_user_yang_dapat_akses_histori_user()
    {
        $user = User::create([
            'name' => 'Tester',
            'email' => 'tester@example.com',
            'password' => bcrypt('password'),
            'role' => 1,
        ]);

        $response = $this->actingAs($user)->get('/user/histori');
        $response->assertStatus(403); // Atau redirect jika pakai middleware
    }
}
