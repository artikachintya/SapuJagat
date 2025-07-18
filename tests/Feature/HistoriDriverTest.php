<?php

namespace Tests\Feature;

use App\Models\Pickup;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HistoriDriverTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function nama_profil_driver_muncul_di_header()
    {
        $driver = User::create([
            'name' => 'driver',
            'email' => 'tester@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        $response = $this->actingAs($this->$driver)->get('/driver/histori');
        $response->assertStatus(200);
        $response->assertSee('Driver1');
    }

    /** @test */
    public function menampilkan_judul_histori_dengan_nama_driver()
    {
        $driver = User::create([
            'name' => 'driver',
            'email' => 'tester@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        $response = $this->actingAs($this->$driver)->get('/driver/histori');
        $response->assertSee('Histori Penukaran Driver1');
    }

    /** @test */
    public function menampilkan_transaksi_dengan_status_selesai()
    {
        $driver = User::create([
            'name' => 'driver',
            'email' => 'tester@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        Pickup::factory()->create([
            'driver_id' => $this->$driver->id,
            'status' => 'Selesai'
        ]);

        $response = $this->actingAs($this->$driver)->get('/driver/histori');
        $response->assertSee('Selesai');
    }

    /** @test */
    public function nama_pengguna_penukar_muncul_di_histori()
    {
        $driver = User::create([
            'name' => 'driver',
            'email' => 'tester@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        Pickup::factory()->create([
            'driver_id' => $this->$driver->id,
            'user_name' => 'John Doe'
        ]);

        $response = $this->actingAs($this->$driver)->get('/driver/histori');
        $response->assertSee('John');
    }

    /** @test */
    public function tombol_lihat_detail_menampilkan_popup()
    {
        $driver = User::create([
            'name' => 'driver',
            'email' => 'tester@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        $pickup = Pickup::factory()->create([
            'driver_id' => $this->$driver->id
        ]);

        $response = $this->actingAs($this->$driver)->get("/driver/histori");
        $response->assertSee('Lihat Detail');

        // Jika menggunakan modal JS, pengujian bisa lanjut pakai Laravel Dusk
    }

    /** @test */
    public function histori_kosong_menampilkan_pesan_khusus()
    {
        $driver = User::create([
            'name' => 'driver',
            'email' => 'tester@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        $response = $this->actingAs($this->$driver)->get('/driver/histori');
        $response->assertSee('Belum ada histori penukaran');
    }

    /** @test */
    public function navigasi_dari_histori_ke_dashboard_berjalan()
    {
        $driver = User::create([
            'name' => 'driver',
            'email' => 'tester@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        $response = $this->actingAs($this->$driver)->get('/driver/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Dashboard Driver');
    }

    /** @test */
    public function tombol_logout_mengarahkan_ke_halaman_login()
    {
        $driver = User::create([
            'name' => 'driver',
            'email' => 'tester@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);
        // Simulasi login driver
        $response = $this->actingAs($this->$driver)->post('/logout');

        // Pastikan setelah logout, pengguna diarahkan ke halaman login
        $response->assertRedirect('/login');

        // Akses halaman dashboard setelah logout seharusnya gagal
        $responseAfter = $this->get('/driver/dashboard');
        $responseAfter->assertRedirect('/login');
    }

}
