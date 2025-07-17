<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use SebastianBergmann\Type\NullType;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    /** @test */
    public function dashboard_termuat_dengan_benar()
    {
        $this->user = User::create([
            'name' => 'Tester',
            'email' => 'tester@example.com',
            'password' => bcrypt('password'),
            'role' => 1,
        ]);

        $response = $this->actingAs($this->user)->get('/pengguna');
        $response->assertStatus(200);
        $response->assertSee('Saldo');
        $response->assertSee("Hi, {$this->user->name}!");
    }
    
    /** @test */
    public function tombol_tukar_sampah_mengarahkan_ke_halaman_penukaran()
    {
        $this->user = User::create([
            'name' => 'Tester4',
            'email' => 'tester4@example.com',
            'password' => bcrypt('password'),
            'role' => 1,
        ]);

        $response = $this->actingAs($this->user)->get('/pengguna');
        $response->assertSee('Tukar Sampah');
        // Simulasi klik bisa diuji dengan route target
        $response = $this->actingAs($this->user)->get('/pengguna/tukar-sampah');
        $response->assertStatus(200);
    }

    /** @test */
    public function tombol_tariksaldo_mengarahkan_ke_halaman_penarikan()
    {
        $this->user = User::create([
            'name' => 'Tester5',
            'email' => 'tester5@example.com',
            'password' => bcrypt('password'),
            'role' => 1,
        ]);

        $response = $this->actingAs($this->user)->get('/pengguna');
        $response->assertSee('Tarik Saldo');
        $response = $this->actingAs($this->user)->get('/pengguna/tarik-saldo');
        $response->assertStatus(200);
    }

    /** @test */
    // public function tombol_ganti_bahasa_mengubah_tampilan()
    // {
    //     $this->user = User::create([
    //         'name' => 'Tester6',
    //         'email' => 'tester6@example.com',
    //         'password' => bcrypt('password'),
    //         'role' => 1,
    //     ]);

    //     $response = $this->actingAs($this->user)->get('/dashboard?lang=id');
    //     $response->assertSee('Bahasa');
    // }

    /** @test */
    public function navigasi_menu_sidebar_berfungsi()
    {
        $this->user = User::create([
            'name' => 'Tester7',
            'email' => 'tester7@example.com',
            'password' => bcrypt('password'),
            'role' => 1,
        ]);

        $menuRoutes = [
            '/pengguna',
            '/pengguna/histori',
            '/pengguna/pelacakan',
            '/pengguna/laporan',
            '/pengguna/tukar-sampah'
        ];

        foreach ($menuRoutes as $route) {
            $response = $this->actingAs($this->user)->get($route);
            $response->assertStatus(200);
        }
    }

    /** @test */
    public function klik_tombol_profile_header_menampilkan_dropdown()
    {
        $this->user = User::create([
            'name' => 'Tester8',
            'email' => 'tester8@example.com',
            'password' => bcrypt('password'),
            'role' => 1,
        ]);

        $response = $this->actingAs($this->user)->get('/pengguna/profile');
        $response->assertSee('Profile');
    }
}
