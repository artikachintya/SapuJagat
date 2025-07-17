<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DashboardAdminTest extends TestCase
{

    /** @test */
    public function halaman_dashboard_dapat_diload()
    {
        $admin = User::create([
            'name' => 'Tester',
            'email' => 'tester@example.com',
            'password' => bcrypt('password'),
            'role' => 2,
        ]);

        $response = $this->actingAs($admin)->get('/admin');

        $response->assertStatus(200);
        $response->assertSee('Welcome, Admin1');
        $response->assertSee('Penukaran Hari Ini');
        $response->assertSee('Uang Keluar');
        $response->assertSee('Pesanan Diproses');
    }

    /** @test */
    public function kartu_penukaran_hari_ini_menampilkan_jumlah_transaksi()
    {

        $admin = User::create([
            'name' => 'Tester',
            'email' => 'tester@example.com',
            'password' => bcrypt('password'),
            'role' => 2,
        ]);

        Order::factory()->count(5)->create([
            'created_at' => now()
        ]);

        $response = $this->actingAs($admin)->get('/admin');
        $response->assertStatus(200);
        $response->assertSee('5 Transaksi');
    }

    /** @test */
    public function kartu_uang_keluar_menampilkan_total_pengeluaran()
    {
        $admin = User::factory()->create();
        Pengeluaran::factory()->create(['jumlah' => 11600]);

        $response = $this->actingAs($admin)->get('/admin');
        $response->assertStatus(200);
        $response->assertSee('Rp 11600');
    }

    /** @test */
    public function tombol_lihat_histori_berfungsi()
    {
        $admin = User::factory()->create();
        $response = $this->actingAs($admin)->get('/admin');
        $response->assertSee('Lihat Semua Histori');
    }

    /** @test */
    public function widget_tugas_persetujuan_menampilkan_order_belum_selesai()
    {
        $admin = User::factory()->create();
        Persetujuan::factory()->create([
            'status' => 'Belum Selesai'
        ]);

        $response = $this->actingAs($admin)->get('/admin');
        $response->assertSee('Belum Selesai');
    }

    /** @test */
    public function tombol_approve_deny_menampilkan_dialog()
    {
        $admin = User::factory()->create();
        $response = $this->actingAs($admin)->get('/admin');
        $response->assertSee('Approve/Deny');
    }

    /** @test */
    public function navigasi_sidebar_ke_jenis_sampah_berfungsi()
    {
        $admin = User::factory()->create();
        $response = $this->actingAs($admin)->get('/jenis-sampah');
        $response->assertStatus(200);
        $response->assertSee('Jenis Sampah');
    }

    /** @test */
    public function admin_dapat_logout_dengan_sukses()
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->post('/logout');
        $response->assertRedirect('/login');
        $this->assertGuest();
    }

    /** @test */
    public function admin_dapat_mengakses_halaman_profile()
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->get('/profile');
        $response->assertStatus(200);
        $response->assertSee('Profile');
    }

    /** @test */
    public function admin_dapat_edit_profile()
    {
        $admin = User::factory()->create([
            'name' => 'Old Name',
        ]);

        $response = $this->actingAs($admin)->put('/profile', [
            'name' => 'New Name',
            'email' => $admin->email,
        ]);

        $response->assertRedirect('/profile');
        $this->assertDatabaseHas('users', [
            'id' => $admin->id,
            'name' => 'New Name',
        ]);
    }
}
