<?php

namespace Tests\Feature;

use App\Models\User;
use GuzzleHttp\Psr7\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LaporanTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    /** @test */
    public function user_can_access_laporan_page()
    {
        $this->user = User::create([
            'name' => 'Tester',
            'email' => 'tester@example.com',
            'password' => bcrypt('password'),
            'role' => 1,
        ]);

        $response = $this->actingAs($this->user)->get('pengguna/laporan');

        $response->assertStatus(200);
        $response->assertSee('Daftar Laporan');
        $response->assertSee('Buat Laporan');
    }

    /** @test */
    public function laporan_list_shows_when_data_available()
    {
        $this->user = User::create([
            'user_id' => 1,
            'name' => 'Uji',
            'email' => 'uji@example.com',
            'password' => bcrypt('password'),
            'role' => 1,
        ]);

        DB::table('reports')->insert([
            'user_id' => 1,
            'report_id' => 1,
            'date_time_report' => now(),
            'report_message' => 'masnya ganteng banget'
        ]);

        $response = $this->actingAs($this->user)->get('pengguna/laporan');

        $response->assertStatus(200);
        $response->assertSee("Daftar Laporan");
        $response->assertSee("masnya ganteng banget");

    }

    /** @test */
    public function user_sees_empty_message_if_no_laporan()
    {
        $this->user = User::create([
            'name' => 'Tanpa Laporan',
            'email' => 'kosong@example.com',
            'password' => bcrypt('password'),
            'role' => 1,
        ]);

        $response = $this->actingAs($this->user)->get('/pengguna/laporan');

        $response->assertStatus(200);
        $response->assertSee("Keluhan {$this->user->name}");
    }
}
