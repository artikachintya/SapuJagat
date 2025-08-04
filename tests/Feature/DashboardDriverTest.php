<?php

namespace Tests\Feature;

use App\Models\Approval;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Pickup;
use App\Models\Trash;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DashboardDriverTest extends TestCase
{
    use RefreshDatabase;

    protected $driver;

    /** @test */
    public function test_halaman_dashboard_driver_dapat_diload()
    {
        $this->driver = User::create([
            'role' => 3,
            'name' => 'Admin1',
            'NIK' => '1234567890',
            'email' => 'old@example.com',
            'phone_num' => '08123456789',
            'password' => Hash::make('oldpassword'),
        ]);

        $response = $this->actingAs($this->driver)->get("/driver?lang=id");
        $response->assertStatus(200);
        // $response->assertSee("Selamat datang, {$this->admin->name}");
        $response->assertSee('Daftar Penjemputan Order');
    }

    /** @test */
    public function tombol_lihat_detail_mengarahkan_ke_halaman_detail()
    {
        $this->driver = User::create([
            'role' => 3,
            'name' => 'Admin1',
            'NIK' => '1234567890',
            'email' => 'old@example.com',
            'phone_num' => '08123456789',
            'password' => Hash::make('oldpassword'),
        ]);

        $pickup = \App\Models\PickUp::factory()->create([
            'user_id' => $this->driver->user_id,
        ]);

        $response = $this->actingAs($this->driver)->get("/driver/pickup/{$pickup->pick_up_id}");

        $response->assertStatus(200);
        $response->assertSeeText('Upload Bukti Pengantaran');
        $response->assertSeeText('Penjemputan Selesai');
        $response->assertSeeText($pickup->order->user->name);
    }

    /** @test */
    public function menampilkan_pesan_jika_tidak_ada_pickup_order()
{
    // Buat user role driver
    $driver = User::factory()->create([
        'role' => 3,
    ]);

    // Login sebagai driver
    $response = $this->actingAs($driver)->get('/driver');

    // Pastikan halaman berhasil dimuat
    $response->assertStatus(200);

    // Pastikan teks fallback muncul di view
    $response->assertSeeText('Tidak ada penjemputan');
}

    /** @test */
    public function driver_dapat_navigasi_kembali_ke_histori()
    {
        $this->driver = User::create([
            'role' => 3,
            'name' => 'Admin1',
            'NIK' => '1234567890',
            'email' => 'old@example.com',
            'phone_num' => '08123456789',
            'password' => Hash::make('oldpassword'),
        ]);

        $response = $this->actingAs($this->driver)->get('/driver/histori');
        $response->assertStatus(200);
        $response->assertSee('Histori');
    }

    // /** @test */
    // public function halaman_detail_pesanan_termuat_dengan_benar()
    // {
    //     $this->driver = User::create([
    //         'role' => 3,
    //         'name' => 'Driver 1',
    //         'NIK' => '1234567890',
    //         'email' => 'driver@example.com',
    //         'phone_num' => '08123456789',
    //         'password' => Hash::make('password'),
    //     ]);

    //     $pickup = Pickup::factory()->create([
    //         'user_id' => $this->driver->user_id,
    //         'alamat' => '708 Bradtke Village Leannestad, KS 49933, Elvieville, California, 50031',
    //     ]);

    //     $response = $this->actingAs($this->driver)->get("/driver");

    //     $response->assertStatus(200);
    //     $response->assertSee('Kaitlin Daugherty');
    //     $response->assertSee('708 Bradtke Village Leannestad, KS 49933, Elvieville, California, 50031');
    //     $response->assertSee('Detail Pesanan');
    //     $response->assertSee('Mulai Menjemput');
    //     $response->assertSee('Pesan');
    //     $response->assertSee('Peta');
    // }




    // /** @test */
    // public function tombol_mulai_menjemput_mengubah_status_pesanan()
    // {
    //     $this->driver = User::create([
    //         'role' => 3,
    //         'name' => 'Admin1',
    //         'NIK' => '1234567890',
    //         'email' => 'old@example.com',
    //         'phone_num' => '08123456789',
    //         'password' => Hash::make('oldpassword'),
    //     ]);
        
    //     $pickup = \App\Models\PickUp::factory()->create([
    //         'user_id' => $this->driver->user_id,
    //     ]);

    //     $response = $this->actingAs($this->driver)->post("/driver/pickup-orders/{$pickup->id}/start");
    //     $response->assertRedirect("/driver/pickup-orders/{$pickup->id}");

    //     $this->assertDatabaseHas('pickup_orders', [
    //         'id' => $pickup->id,
    //         'status' => 'Dalam Perjalanan'
    //     ]);
    // }

    /** @test */
    public function driver_dapat_mengakses_form_edit_profile()
    {
        $this->driver = User::create([
            'role' => 3,
            'name' => 'Admin1',
            'NIK' => '1234567890',
            'email' => 'old@example.com',
            'phone_num' => '08123456789',
            'password' => Hash::make('oldpassword'),
        ]);

        $response = $this->actingAs($this->driver)->get('/driver/profile/edit');
        $response->assertStatus(200);
    }

    /** @test */
    public function tombol_pesan_mengarah_ke_halaman_chat_user()
    {
        $this->driver = User::create([
            'role' => 3,
            'name' => 'Admin1',
            'NIK' => '1234567890',
            'email' => 'old@example.com',
            'phone_num' => '08123456789',
            'password' => Hash::make('oldpassword'),
        ]);

        $response = $this->actingAs($this->driver)->get("/driver/chat");
        $response->assertStatus(200);
        $response->assertSee('Daftar Pesan Pengguna');
    }
}
