<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TukarSaldoTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    /** @test */
    public function halaman_tarik_saldo_dapat_diakses()
    {
        $this->user = User::create([
            'name' => 'tester',
            'email' => 'tester@example.com',
            'password' => bcrypt('password'),
            'role' => 1,
        ]);

        $response = $this->actingAs($this->user)->get('/pengguna/tarik-saldo');
        $response->assertStatus(200);
        $response->assertSee('Tarik Saldo Pengguna');
    }

    /** @test */
    public function menampilkan_informasi_saldo()
    {
        $this->user = User::create([
            'name' => 'driver',
            'email' => 'tester@example.com',
            'password' => bcrypt('password'),
            'role' => 1,
        ]);

        $response = $this->actingAs($this->user)->get('/pengguna/tarik-saldo');
        $response->assertSee("Rp{$this->user->balance}");
    }

    /** @test */
    public function menolak_nilai_penarikan_dibawah_minimum()
    {
        $this->user = User::create([
            'name' => 'driver',
            'email' => 'tester@example.com',
            'password' => bcrypt('password'),
            'role' => 1,
        ]);

        $response = $this->actingAs($this->user)->post('/pengguna/tarik-saldo', [
            'amount' => 40000
        ]);
        $response->assertSessionHasErrors(['amount']);
    }

    /** @test */
    public function estimasi_cair_ditampilkan()
    {
        $this->user = User::create([
            'name' => 'tester',
            'email' => 'tester@example.com',
            'password' => bcrypt('password'),
            'role' => 1,
        ]);

        $response = $this->actingAs($this->user)->get('/pengguna/tarik-saldo');
        $response->assertSee('Dana dari penjualan sampah akan masuk ke rekening maksimal dalam 3 hari kerja');
    }

    /** @test */
    public function menampilkan_informasi_rekening_tujuan()
    {
        $this->user = User::create([
            'name' => 'tester',
            'email' => 'tester@example.com',
            'password' => bcrypt('password'),
            'role' => 1,
        ]);

        $response = $this->actingAs($this->user)->get('/pengguna/tarik-saldo');
        $response->assertSee('Transfer ke');
        $response->assertSee('Nomor Rekening');
    }

    /** @test */
    public function tombol_tidak_aktif_jika_saldo_nol()
    {
        $this->user = User::create([
            'name' => 'testing',
            'email' => 'tester@example.com',
            'password' => bcrypt('password'),
            'role' => 1,
        ]);

        $response = $this->actingAs($this->user)->get('/pengguna/tarik-saldo');
        $response->assertSee("Rp0");
    }

    /** @test */
    public function navigasi_kembali_ke_dashboard_berjalan()
    {
        $this->user = User::create([
            'name' => 'testing',
            'email' => 'tester@example.com',
            'password' => bcrypt('password'),
            'role' => 1,
        ]);

        $response = $this->actingAs($this->user)->get('/pengguna');
        $response->assertStatus(200);
        $response->assertSee('Dashboard Pengguna');
    }

}
