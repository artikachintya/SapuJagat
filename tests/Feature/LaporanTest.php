<?php

namespace Tests\Feature;

use App\Models\User;
use GuzzleHttp\Psr7\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class LaporanTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_access_laporan_page()
    {
        $user = User::create([
            'name' => 'Tester',
            'email' => 'tester@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        $response = $this->actingAs($user)->get('/laporan');

        $response->assertStatus(200);
        $response->assertSee('Daftar Laporan');
        $response->assertSee('Buat Laporan');
    }

    /** @test */
    public function laporan_list_shows_when_data_available()
    {
        $user = User::create([
            'name' => 'Uji',
            'email' => 'uji@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        DB::table('users')->insert([
            'user_id' => $user->id,
            'judul' => 'Keluhan Kreasi',
            'deskripsi' => 'Isi keluhan...',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->actingAs($user)->get('/laporan');

        $response->assertStatus(200);
        $response->assertSee('Keluhan Kreasi');
    }

    /** @test */
    public function user_sees_empty_message_if_no_laporan()
    {
        $user = User::create([
            'name' => 'Tanpa Laporan',
            'email' => 'kosong@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        $response = $this->actingAs($user)->get('/laporan');

        $response->assertStatus(200);
        $response->assertSee('Belum ada laporan'); // Sesuaikan dengan teks kosong di UI kamu
    }

    /** @test */
    public function guest_cannot_access_laporan()
    {
        $response = $this->get('/laporan');
        $response->assertRedirect('/login');
    }

}
