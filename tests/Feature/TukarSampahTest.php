<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Pickup;
use App\Models\Trash;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TukarSampahTest extends TestCase
{
    use RefreshDatabase;

    protected $user, $userinfo, $orderdetail, $order;
    protected $admin, $driver, $trash;

    /** @test */
    public function user_can_access_tukar_sampah_page()
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

        $response = $this->actingAs($this->user)->get('/pengguna/tukar-sampah');

        $response->assertStatus(200);
        $response->assertSee('Tukar Sampah');
    }

    /** @test */
    public function halaman_tukar_sampah_dapat_diakses_dan_menampilkan_data_sampah()
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

        $response = $this->actingAs($this->user)->get('/pengguna/tukar-sampah');

        $response->assertStatus(200);
        $response->assertSee('Pilih Sampah yang Ingin Ditukar');
        $response->assertSee('Organik');
        $response->assertSee('Anorganik');
        $response->assertSee('Lanjut');
    }

    /** @test */
    public function pengguna_dapat_mengunggah_bukti_dan_meminta_penjemputan()
    {
    Storage::fake('public');

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

    $file = UploadedFile::fake()->image('bukti_pesanan.jpg');

    $payload = [
        'waktu_penjemputan' => '2025-07-18 10:00:00',
        'photo' => $file,
    ];

    $response = $this->actingAs($this->user)
                    ->post('/pengguna/ringkasan-pesanan/jemput', $payload);

    $response->assertStatus(302);

    }
}
