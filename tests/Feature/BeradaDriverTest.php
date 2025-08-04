<?php

namespace Tests\Feature;

use App\Models\Approval;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Trash;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class BeradaDriverTest extends TestCase
{
    use RefreshDatabase;

    protected $driver;
    /** @test */
    public function halaman_pickup_order_dapat_diakses_driver()
    {
        $this->driver = User::create([
            'name' => 'driver1',
            'email' => 'driver1@example.com',
            'password' => Hash::make('password5'),
            'role' => 3,
        ]);
        $this->driver = User::create([
            'role' => 3,
            'name' => 'Admin1',
            'NIK' => '1234567890',
            'email' => 'old@example.com',
            'phone_num' => '08123456789',
            'password' => Hash::make('oldpassword'),
        ]);

        $response = $this->actingAs($this->driver)->get('/driver');
        $response->assertStatus(200);
        $response->assertSee('Daftar Pengambilan Pesanan');
    }


    /** @test */
    public function tombol_lihat_detail_mengarahkan_ke_halaman_detail()
    {
        $driver = User::create([
            'name' => 'driver',
            'email' => 'tester@example.com',
            'password' => bcrypt('password'),
            'role' => 3,
        ]);

        $pickup = Order::factory()->create([
            'driver_id' => $this->$driver->id,
        ]);

        $response = $this->actingAs($this->$driver)->get("/driver/pickup-orders/{$pickup->id}");
        $response->assertStatus(200);
        $response->assertSee('Detail Pesanan');
    }

    /** @test */
    public function menampilkan_pesan_jika_tidak_ada_pickup_order()
    {
        $driver = User::create([
            'name' => 'driver',
            'email' => 'tester@example.com',
            'password' => bcrypt('password'),
            'role' => 3,
        ]);

        $response = $this->actingAs($this->$driver)->get('/driver/pickup-orders');
        $response->assertSee('Belum ada pesanan yang harus diambil');
    }

    /** @test */
    public function driver_dapat_navigasi_kembali_ke_dashboard()
    {
        $driver = User::create([
            'name' => 'driver',
            'email' => 'tester@example.com',
            'password' => bcrypt('password'),
            'role' => 3,
        ]);

        $response = $this->actingAs($this->$driver)->get('/driver/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Dashboard Driver');
    }

    protected function setUp(): void
    {
        $driver = User::create([
            'name' => 'driver',
            'email' => 'tester@example.com',
            'password' => bcrypt('password'),
            'role' => 3,
        ]);

        parent::setUp();
        $this->$driver = User::factory()->create(['role' => 'driver', 'name' => 'Driver Sapu Jagat']);
    }

    /** @test */
    public function halaman_detail_pesanan_termuat_dengan_benar()
    {
        $driver = User::create([
            'name' => 'driver',
            'email' => 'tester@example.com',
            'password' => bcrypt('password'),
            'role' => 3,
        ]);

        $pickup = Pickup::factory()->create([
            'driver_id' => $this->$driver->id,
            'user_name' => 'John Doe',
            'alamat' => 'Jl. Merdeka No.1, Jakarta Pusat, DKI Jakarta, 10110',
            'status' => 'Menunggu Pengambilan'
        ]);

        $response = $this->actingAs($this->$driver)->get("/driver/pickup-orders/{$pickup->id}");
        $response->assertStatus(200);
        $response->assertSee('Detail Pesanan');
        $response->assertSee('John Doe');
        $response->assertSee('Jl. Merdeka No.1, Jakarta Pusat, DKI Jakarta, 10110');
        $response->assertSee('Mulai Menjemput');
        $response->assertSee('Pesan');
        $response->assertSee('Peta');
    }

    /** @test */
    public function tombol_mulai_menjemput_mengubah_status_pesanan()
    {
        $driver = User::create([
            'name' => 'driver',
            'email' => 'tester@example.com',
            'password' => bcrypt('password'),
            'role' => 3,
        ]);

        $pickup = Pickup::factory()->create([
            'driver_id' => $this->$driver->id,
            'status' => 'Menunggu Pengambilan'
        ]);

        $response = $this->actingAs($this->$driver)->post("/driver/pickup-orders/{$pickup->id}/start");
        $response->assertRedirect("/driver/pickup-orders/{$pickup->id}");

        $this->assertDatabaseHas('pickup_orders', [
            'id' => $pickup->id,
            'status' => 'Dalam Perjalanan'
        ]);
    }

    /** @test */
    public function driver_dapat_mengakses_form_edit_profile()
    {
        $driver = User::create([
            'name' => 'driver',
            'email' => 'tester@example.com',
            'password' => bcrypt('password'),
            'role' => 3,
        ]);

        $response = $this->actingAs($this->$driver)->get('/driver/profile/edit');
        $response->assertStatus(200);
        $response->assertSee('Edit Profile');
    }

    /** @test */
    public function tombol_pesan_mengarah_ke_halaman_chat_user()
    {
        $this->driver = User::create([
            'user_id' => 1,
            'name' => 'driver',
            'email' => 'tester@example.com',
            'password' => bcrypt('password'),
            'role' => 3,
        ]);

        $response = $this->actingAs($this->driver)->get("/driver/chat");
        $response->assertStatus(200);
        $response->assertSee('Daftar Pesan Pengguna');
    }
}
