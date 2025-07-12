<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use Tests\TestCase;

class DasboardTest extends TestCase
{

    /** @test */
    public function user_can_access_dasboard()
    {
        $user = User::create([
            'name' => 'Jhon Doe',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 1
        ]);

        $response = $this->actingAs($user)->get('/pengguna');
        $response->assertStatus(200);

        $this->get('/pengguna/tukar-sampah')->assertStatus(200)->assertSee('Tukar Sampah');
        $this->get('/pengguna/histori')->assertStatus(200)->assertSee('Histori');
        $this->get('/pengguna/pelacakan')->assertStatus(200)->assertSee('Pelacakan');
        $this->get('/pengguna/laporan')->assertStatus(200)->assertSee('Laporan');
        $this->get('/pengguna/tarik-saldo')->assertStatus(200)->assertSee('Tarik Saldo');

    }

    /** @test */
    public function authenticated_user_with_wrong_role_is_forbidden()
    {
        $user = User::create([
            'name' => 'adminTesting',
            'email' => 'admin8@gmail.com',
            'password' => bcrypt('password'),
            'role' => 2,
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(404);
    }

    /** @test */
    // public function admin_can_access_dasboard()
    // {
    //     $user = User::create([
    //         'name' => 'Admin Coba Coba',
    //         'email' => 'admin9@example.com',
    //         'password' => bcrypt('password10'),
    //         'role' => 2
    //     ]);

    //     $response = $this->actingAs($user)->get('/admin');
    //     $response->assertStatus(200);

    //     $this->get('/admin/jenis-sampah')->assertStatus(200)->assertSee('');
    //     $this->get('/admin/histori')->assertStatus(200)->assertSee('');
    //     $this->get('/admin/persetujuan')->assertStatus(200)->assertSee('');
    //     $this->get('/admin/laporan')->assertStatus(200)->assertSee('');
    //     $this->get('/admin/print-data')->assertStatus(200)->assertSee('');

    // }
}
