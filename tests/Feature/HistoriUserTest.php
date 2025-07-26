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

    protected $user;

    /** @test */
    public function halaman_histori_dapat_diakses_dan_menampilkan_judul()
    {

        $this->user = User::create([
            'name' => 'Tester',
            'email' => 'tester@example.com',
            'password' => bcrypt('password'),
            'role' => 1,
        ]);

        $response = $this->actingAs($this->user)->get('/pengguna/histori');
        $response->assertStatus(200);
        $response->assertSee('Daftar Histori');
        $response->assertSee("Histori Penukaran {$this->user->name}");
    }

    /** @test */
    public function histori_kosong_menampilkan_pesan_khusus()
    {
        $this->user = User::create([
            'name' => 'Tester',
            'email' => 'tester@example.com',
            'password' => bcrypt('password'),
            'role' => 1,
        ]);

        $response = $this->actingAs($this->user)->get('/pengguna/histori');
        $response->assertSee('Tidak ada histori penukaran tersedia.');
    }

    /** @test */
    public function pengguna_dapat_kembali_ke_dashboard_dari_histori()
    {
        $this->user = User::create([
            'name' => 'Tester',
            'email' => 'tester@example.com',
            'password' => bcrypt('password'),
            'role' => 1,
        ]);

        $response = $this->actingAs($this->user)->get('/pengguna?lang=id');
        $response->assertStatus(200);
        $response->assertSee("Hai, {$this->user->name}!");
    }

    /** @test */
    public function histori_muncul_jika_transaksi_ada()
    {
        $this->user = User::create([
            'user_id' => '1',
            'name' => 'Tester',
            'email' => 'tester@example.com',
            'password' => bcrypt('password'),
            'role' => 1,
        ]);

        Order::factory()->create([
            'user_id' => $this->user->user_id,
            'order_id' => 1,
        ]);

        $response = $this->actingAs($this->user)->get('/pengguna/histori');
        $response->assertSee('Selesai');
        $response->assertSee('Tester');
    }
}
