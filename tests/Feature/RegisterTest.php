<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    /** @test */
    public function user_can_register_and_redirect_to_login(): void
    {
        // buka halaman /register
        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'jhon@gmail.com',
            'password' => 'Jhon1234!',
            'alamat' => 'Jl. Contoh No. 123',
            'provinsi' => 'Jawa Barat',
            'kota' => 'Bandung',
            'kode_pos' => '40123',
            'nik' => '1234567890123456',
            'telepon' => '08123456789',
        ]);
        // pastikan halamannya bisa di buka
        $response->assertStatus(302);
        $this->get('/login')->assertStatus(200);
    }

    /** @test */
    public function user_can_not_register_with_existing_email(): void
    {
        // buat user dengan email yang sudah ada
        $response = $this->from('/register')->post('/register', [
            'email' => 'not-an-email',
            'name' => 'Jane Doe',
        ]);
        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function fails_with_password(){
        $response = $this->from('/register')->post('/register', [
            'name' => 'Jane Doe',
            'email' => 'jhonedoe@gmail.com',
            'password' => '123', ]);
        $response->assertSessionHasErrors('password');
    }

    /** @test */
    public function registration_fails_when_required_fields_are_missing()
    {
        $response = $this->from('/register')->post('/register', []); // semua kosong

        $response->assertRedirect('/register');
        $response->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function register_page_displays_all_fields()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('Nama Lengkap');
        $response->assertSee('Email');
        $response->assertSee('Kata Sandi');
        $response->assertSee('Alamat');
        $response->assertSee('Provinsi');
        $response->assertSee('Kota');
        $response->assertSee('Kode Pos');
        $response->assertSee('NIK');
        $response->assertSee('Nomor Telepon');
        $response->assertSee('Daftar');
    }
}
