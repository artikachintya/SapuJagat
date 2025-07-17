<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DashboardAdminTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_halaman_dashboard_dapat_diload()
    {
        // Create a new admin user manually
        $admin = User::factory()->create([
            'name' => 'Admin1',
            'email' => 'admin1@example.com',
            'role' => 2, // if your app checks for this
        ]);

        // Act as that admin
        $response = $this->actingAs($admin)->get('/admin');


        // Assert content visible on dashboard
        $this->assertAuthenticated(); // generic check
        $this->assertAuthenticatedAs($admin);
        $response->assertStatus(200);
        $response->assertSee('<h3 class="mb-0"><b>Welcome,</b> <i>Admin1</i></h3>', false);
        $response->assertSee('Penukaran Hari Ini');
        $response->assertSee('Uang Keluar');
        $response->assertSee('Pesanan Diproses');
    }

    /** @test */
    public function kartu_penukaran_hari_ini_menampilkan_jumlah_transaksi()
    {
        $admin = User::factory()->create([
            'email' => 'admin5@example.com'
        ]);

        // Orders from random users — NOT the admin
        Order::factory()->count(5)->create();

        // Login as admin
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
