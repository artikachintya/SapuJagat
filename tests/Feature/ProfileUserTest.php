<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProfileUserTest extends TestCase
{
    use RefreshDatabase;

    protected $user, $userinfo;

    /** @test */
    public function halaman_profil_termuat_dengan_benar()
    {
        $this->user = User::create([
            'user_id' => 10,
            'name' => 'Username',
            'password' => bcrypt('password'),
            'email' => 'kreasipxk1@gmail.com',
            'phone_num' => '081234567823',
            'nik' => '3578263788998981',
            'role' => 1,
        ]);

        $this->userinfo = UserInfo::create([
            'user_id' => $this->user->user_id,
            'address' => 'Jl. Kekanak-kanakan No.2',
            'province' => 'Jawa Timur',
            'city' => 'Jambi',
            'postal_code' => '40382',
            'balance' => '30000'
        ]);

        $response = $this->actingAs($this->user)->get('/pengguna/profile');
        $response->assertStatus(200);
        $response->assertSee('Edit Profil');
        $response->assertSee('Informasi Profil Pengguna');
        $response->assertSee('Username');
    }

    /** @test */
    public function informasi_nama_lengkap_tampil()
    {
        $this->user = User::create([
            'user_id' => 10,
            'name' => 'Username',
            'password' => bcrypt('password'),
            'email' => 'kreasipxk1@gmail.com',
            'phone_num' => '081234567823',
            'nik' => '3578263788998981',
            'role' => 1,
        ]);

        $this->userinfo = UserInfo::create([
            'user_id' => $this->user->user_id,
            'address' => 'Jl. Kekanak-kanakan No.2',
            'province' => 'Jawa Timur',
            'city' => 'Jambi',
            'postal_code' => '40382',
            'balance' => '30000'
        ]);

        $response = $this->actingAs($this->user)->get('/pengguna/profile');
        $response->assertSee('Username');
    }

    /** @test */
    public function menampilkan_nik_pengguna()
    {
        $this->user = User::create([
            'user_id' => 10,
            'name' => 'Username',
            'password' => bcrypt('password'),
            'email' => 'kreasipxk1@gmail.com',
            'phone_num' => '081234567823',
            'NIK' => '3578263788998981',
            'role' => 1,
        ]);

        $this->userinfo = UserInfo::create([
            'user_id' => $this->user->user_id,
            'address' => 'Jl. Kekanak-kanakan No.2',
            'province' => 'Jawa Timur',
            'city' => 'Jambi',
            'postal_code' => '40382',
            'balance' => '30000'
        ]);

        $response = $this->actingAs($this->user)->get('/pengguna/profile');
        $response->assertSee('3578263788998981');
    }

    /** @test */
    public function email_pengguna_ditampilkan()
    {
        $this->user = User::create([
            'user_id' => 10,
            'name' => 'Username',
            'password' => bcrypt('password'),
            'email' => 'kreasipxk1@gmail.com',
            'phone_num' => '081234567823',
            'nik' => '3578263788998981',
            'role' => 1,
        ]);

        $this->userinfo = UserInfo::create([
            'user_id' => $this->user->user_id,
            'address' => 'Jl. Kekanak-kanakan No.2',
            'province' => 'Jawa Timur',
            'city' => 'Jambi',
            'postal_code' => '40382',
            'balance' => '30000'
        ]);

        $response = $this->actingAs($this->user)->get('/pengguna/profile');
        $response->assertSee('kreasipxk1@gmail.com');
    }

    /** @test */
    public function alamat_lengkap_pengguna_ditampilkan()
    {
        $this->user = User::create([
            'user_id' => 10,
            'name' => 'Username',
            'password' => bcrypt('password'),
            'email' => 'kreasipxk1@gmail.com',
            'phone_num' => '081234567823',
            'nik' => '3578263788998981',
            'role' => 1,
        ]);

        $this->userinfo = UserInfo::create([
            'user_id' => $this->user->user_id,
            'address' => 'Jl. Kekanak-kanakan No.2',
            'province' => 'Jawa Timur',
            'city' => 'Jambi',
            'postal_code' => '40382',
            'balance' => '30000'
        ]);

        $response = $this->actingAs($this->user)->get('/pengguna/profile');
        $response->assertSee('Jl. Kekanak-kanakan No.2');
    }

    /** @test */
    public function provinsi_dan_kota_ditampilkan()
    {
        $this->user = User::create([
            'user_id' => 10,
            'name' => 'Username',
            'password' => bcrypt('password'),
            'email' => 'kreasipxk1@gmail.com',
            'phone_num' => '081234567823',
            'nik' => '3578263788998981',
            'role' => 1,
        ]);

        $this->userinfo = UserInfo::create([
            'user_id' => $this->user->user_id,
            'address' => 'Jl. Kekanak-kanakan No.2',
            'province' => 'Jawa Timur',
            'city' => 'Jambi',
            'postal_code' => '40382',
            'balance' => '30000'
        ]);

        $response = $this->actingAs($this->user)->get('/pengguna/profile');
        $response->assertSee('Jawa Timur');
        $response->assertSee('Jambi');
    }

    /** @test */
    public function kode_pos_dan_telepon_ditampilkan()
    {
        $this->user = User::create([
            'user_id' => 10,
            'name' => 'Username',
            'password' => bcrypt('password'),
            'email' => 'kreasipxk1@gmail.com',
            'phone_num' => '081234567823',
            'nik' => '3578263788998981',
            'role' => 1,
        ]);

        $this->userinfo = UserInfo::create([
            'user_id' => $this->user->user_id,
            'address' => 'Jl. Kekanak-kanakan No.2',
            'province' => 'Jawa Timur',
            'city' => 'Jambi',
            'postal_code' => '40382',
            'balance' => '30000'
        ]);

        $response = $this->actingAs($this->user)->get('/pengguna/profile');
        $response->assertSee('40382');
        $response->assertSee('+62 081234567823');
    }

    /** @test */
    public function navigasi_sidebar_berfungsi()
    {
        $this->user = User::create([
            'user_id' => 10,
            'name' => 'Username',
            'password' => bcrypt('password'),
            'email' => 'kreasipxk1@gmail.com',
            'telepon' => '081234567823',
            'nik' => '3578263788998981',
            'role' => 1,
        ]);

        $routes = ['/pengguna', '/pengguna/tukar-sampah', '/pengguna/histori'];
        foreach ($routes as $route) {
            $response = $this->actingAs($this->user)->get($route);
            $response->assertStatus(200);
        }
    }

    /** @test */
    public function tombol_edit_profil_mengarahkan_ke_halaman_edit()
    {
        $this->user = User::create([
            'user_id' => 10,
            'name' => 'Username',
            'password' => bcrypt('password'),
            'email' => 'kreasipxk1@gmail.com',
            'telepon' => '081234567823',
            'nik' => '3578263788998981',
            'role' => 1,
        ]);

        $response = $this->actingAs($this->user)->get('/pengguna/profile');
        $response->assertSee('Informasi Profil Pengguna');

        $editResponse = $this->actingAs($this->user)->get('/pengguna/profile?edit');
        $editResponse->assertStatus(200);
        $editResponse->assertSee('Edit Profil');
    }
}
