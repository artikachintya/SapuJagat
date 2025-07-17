<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProfileUserTest extends TestCase
{


    /** @test */
    public function halaman_profil_termuat_dengan_benar()
    {
        $user = User::factory()->create([
            'name' => 'Username',
            'email' => 'kreasi.pxk1@gmail.com',
            'nik' => '3578263788998981',
            'alamat' => 'Jl. Kekanak-kanakan No.2',
            'provinsi' => 'Jawa Timur',
            'kota' => 'Jambi',
            'kode_pos' => '40382',
            'telepon' => '+62 081234567823'
        ]);

        $response = $this->actingAs($this->$user)->get('/user/profile');
        $response->assertStatus(200);
        $response->assertSee('Edit Profil');
        $response->assertSee('Username');
    }

    /** @test */
    public function informasi_nama_lengkap_tampil()
    {
        $user = User::factory()->create([
            'name' => 'Username',
            'email' => 'kreasi.pxk1@gmail.com',
            'nik' => '3578263788998981',
            'alamat' => 'Jl. Kekanak-kanakan No.2',
            'provinsi' => 'Jawa Timur',
            'kota' => 'Jambi',
            'kode_pos' => '40382',
            'telepon' => '+62 081234567823'
        ]);

        $response = $this->actingAs($this->$user)->get('/user/profile');
        $response->assertSee('Username');
    }

    /** @test */
    public function menampilkan_nik_pengguna()
    {
        $user = User::factory()->create([
            'name' => 'Username',
            'email' => 'kreasi.pxk1@gmail.com',
            'nik' => '3578263788998981',
            'alamat' => 'Jl. Kekanak-kanakan No.2',
            'provinsi' => 'Jawa Timur',
            'kota' => 'Jambi',
            'kode_pos' => '40382',
            'telepon' => '+62 081234567823'
        ]);

        $response = $this->actingAs($this->$user)->get('/user/profile');
        $response->assertSee('3578263788998981');
    }

    /** @test */
    public function email_pengguna_ditampilkan()
    {
        $user = User::factory()->create([
            'name' => 'Username',
            'email' => 'kreasi.pxk1@gmail.com',
            'nik' => '3578263788998981',
            'alamat' => 'Jl. Kekanak-kanakan No.2',
            'provinsi' => 'Jawa Timur',
            'kota' => 'Jambi',
            'kode_pos' => '40382',
            'telepon' => '+62 081234567823'
        ]);

        $response = $this->actingAs($this->$user)->get('/user/profile');
        $response->assertSee('kreasi.pxk1@gmail.com');
    }

    /** @test */
    public function alamat_lengkap_pengguna_ditampilkan()
    {
        $user = User::factory()->create([
            'name' => 'Username',
            'email' => 'kreasi.pxk1@gmail.com',
            'nik' => '3578263788998981',
            'alamat' => 'Jl. Kekanak-kanakan No.2',
            'provinsi' => 'Jawa Timur',
            'kota' => 'Jambi',
            'kode_pos' => '40382',
            'telepon' => '+62 081234567823'
        ]);

        $response = $this->actingAs($this->$user)->get('/user/profile');
        $response->assertSee('Jl. Kekanak-kanakan No.2');
    }

    /** @test */
    public function provinsi_dan_kota_ditampilkan()
    {
        $user = User::factory()->create([
            'name' => 'Username',
            'email' => 'kreasi.pxk1@gmail.com',
            'nik' => '3578263788998981',
            'alamat' => 'Jl. Kekanak-kanakan No.2',
            'provinsi' => 'Jawa Timur',
            'kota' => 'Jambi',
            'kode_pos' => '40382',
            'telepon' => '+62 081234567823'
        ]);

        $response = $this->actingAs($this->$user)->get('/user/profile');
        $response->assertSee('Jawa Timur');
        $response->assertSee('Jambi');
    }

    /** @test */
    public function kode_pos_dan_telepon_ditampilkan()
    {
        $user = User::factory()->create([
            'name' => 'Username',
            'email' => 'kreasi.pxk1@gmail.com',
            'nik' => '3578263788998981',
            'alamat' => 'Jl. Kekanak-kanakan No.2',
            'provinsi' => 'Jawa Timur',
            'kota' => 'Jambi',
            'kode_pos' => '40382',
            'telepon' => '+62 081234567823'
        ]);

        $response = $this->actingAs($this->$user)->get('/user/profile');
        $response->assertSee('40382');
        $response->assertSee('+62 081234567823');
    }

    /** @test */
    public function navigasi_sidebar_berfungsi()
    {$user = User::factory()->create([
            'name' => 'Username',
            'email' => 'kreasi.pxk1@gmail.com',
            'nik' => '3578263788998981',
            'alamat' => 'Jl. Kekanak-kanakan No.2',
            'provinsi' => 'Jawa Timur',
            'kota' => 'Jambi',
            'kode_pos' => '40382',
            'telepon' => '+62 081234567823'
        ]);

        $routes = ['/user/dashboard', '/user/exchange', '/user/history'];
        foreach ($routes as $route) {
            $response = $this->actingAs($this->$user)->get($route);
            $response->assertStatus(200);
        }
    }

    /** @test */
    public function background_edukatif_ditampilkan()
    {
        $user = User::factory()->create([
            'name' => 'Username',
            'email' => 'kreasi.pxk1@gmail.com',
            'nik' => '3578263788998981',
            'alamat' => 'Jl. Kekanak-kanakan No.2',
            'provinsi' => 'Jawa Timur',
            'kota' => 'Jambi',
            'kode_pos' => '40382',
            'telepon' => '+62 081234567823'
        ]);

        $response = $this->actingAs($this->$user)->get('/user/profile');
        $response->assertSee('Every piece of plastic ever made still exists today');
    }

    /** @test */
    public function tombol_edit_profil_mengarahkan_ke_halaman_edit()
    {
        $user = User::factory()->create([
            'name' => 'Username',
            'email' => 'kreasi.pxk1@gmail.com',
            'nik' => '3578263788998981',
            'alamat' => 'Jl. Kekanak-kanakan No.2',
            'provinsi' => 'Jawa Timur',
            'kota' => 'Jambi',
            'kode_pos' => '40382',
            'telepon' => '+62 081234567823'
        ]);

        $response = $this->actingAs($this->$user)->get('/user/profile');
        $response->assertSee('Edit Profil');

        $editResponse = $this->actingAs($this->$user)->get('/user/profile/edit');
        $editResponse->assertStatus(200);
        $editResponse->assertSee('Form Edit Profil');
    }

    /** @test */
    public function user_dapat_mengedit_dan_menyimpan_data()
    {
        $user = User::factory()->create([
            'name' => 'Username',
            'email' => 'kreasi.pxk1@gmail.com',
            'nik' => '3578263788998981',
            'alamat' => 'Jl. Kekanak-kanakan No.2',
            'provinsi' => 'Jawa Timur',
            'kota' => 'Jambi',
            'kode_pos' => '40382',
            'telepon' => '+62 081234567823'
        ]);

        $response = $this->actingAs($this->$user)->put('/user/profile/update', [
            'name' => 'Username Baru',
            'alamat' => 'Jl. Baru No.3',
            'telepon' => '+62 081999999999',
        ]);

        $response->assertRedirect('/user/profile');

        $this->assertDatabaseHas('users', [
            'id' => $this->$user->id,
            'name' => 'Username Baru',
            'alamat' => 'Jl. Baru No.3',
            'telepon' => '+62 081999999999',
        ]);
    }

}
