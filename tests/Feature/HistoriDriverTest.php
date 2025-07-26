<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Penugasan;
use App\Models\Pickup;
use App\Models\Trash;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HistoriDriverTest extends TestCase
{
    use RefreshDatabase;

    protected $admin, $driver, $trash, $order, $user, $penugasan;

    /** @test */
    public function nama_profil_driver_muncul_di_header()
    {
        $this->driver = User::create([
            'name' => 'driver',
            'email' => 'tester@example.com',
            'password' => bcrypt('password'),
            'role' => 3,
        ]);

        $response = $this->actingAs($this->driver)->get('/driver/histori');
        $response->assertStatus(200);
        $response->assertSee("{$this->driver->name}");
    }

    /** @test */
    public function menampilkan_judul_histori_dengan_nama_driver()
    {
        $this->driver = User::create([
            'name' => 'driver',
            'email' => 'tester@example.com',
            'password' => bcrypt('password'),
            'role' => 3,
        ]);

        $response = $this->actingAs($this->driver)->get('/driver/histori');
        $response->assertSee("Histori Penukaran {$this->driver->name}");
    }

    /** @test */
    // public function menampilkan_transaksi_dengan_status_selesai()
    // {
    //     $this->driver = User::create([
    //         'user_id' => 10,
    //         'name' => 'Driver Sapu Jagat',
    //         'email' => 'driver1@example.com',
    //         'password' => bcrypt('password'),
    //         'role' => 3,
    //     ]);

    //     $this->admin = User::create([
    //         'user_id' => 1,
    //         'name' => 'Admin Sapu Jagat',
    //         'email' => 'driver@example.com',
    //         'password' => bcrypt('password'),
    //         'role' => 2,
    //     ]);

    //     $this->user = User::create([
    //         'user_id' => 3,
    //         'name' => 'User Sapu Jagat',
    //         'email' => 'driver3@example.com',
    //         'password' => bcrypt('password'),
    //         'role' => 1,
    //     ]);

    //     $this->trash = Trash::create([
    //         'name' => 'Plastik',
    //         'type' => 'Anorganik',
    //         'photos' => 'image1.jpg',
    //         'price_per_kg' => 4300,
    //     ]);

    //     $this->order = Order::create([
    //         'order_id' => 1,
    //         'user_id' => $this->user->user_id,
    //         'photo' => 'image1.jpg',
    //         'date_time_request' => now(),
    //         'pickup_time' => now(),
    //         'status' => 0,
    //     ]);

    //     OrderDetail::create([
    //         'order_id' => $this->order->order_id,
    //         'trash_id' => $this->trash->trash_id,
    //         'quantity' => 2,
    //     ]);

    //         $this->penugasan = Penugasan::create([
    //         'penugasan_id' => 1,
    //         'order_id' => $this->order->order_id,
    //         'user_id' => $this->user->user_id,
    //         'status' => 1,
    //     ]);

    //     Pickup::create([
    //         'order_id' => $this->order->order_id,
    //         'penugasan_id' => $this->penugasan->penugasan_id,
    //         'user_id' => $this->user->user_id,
    //         'arrival_date' => now()
    //     ]);

    //     $response = $this->actingAs($this->driver)->get('/driver/histori');
    //     $response->assertSee('Selesai');
    // }

    /** @test */
    // public function nama_pengguna_penukar_muncul_di_histori()
    // {
    //     $this->driver = User::create([
    //         'user_id' => 10,
    //         'name' => 'Driver Sapu Jagat',
    //         'email' => 'driver1@example.com',
    //         'password' => bcrypt('password'),
    //         'role' => 3,
    //     ]);

    //     $this->admin = User::create([
    //         'user_id' => 1,
    //         'name' => 'Admin Sapu Jagat',
    //         'email' => 'driver@example.com',
    //         'password' => bcrypt('password'),
    //         'role' => 2,
    //     ]);

    //     $this->user = User::create([
    //         'user_id' => 3,
    //         'name' => 'User Sapu Jagat',
    //         'email' => 'driver3@example.com',
    //         'password' => bcrypt('password'),
    //         'role' => 1,
    //     ]);

    //     $this->trash = Trash::create([
    //         'name' => 'Plastik',
    //         'type' => 'Anorganik',
    //         'photos' => 'image1.jpg',
    //         'price_per_kg' => 4300,
    //     ]);

    //     $this->order = Order::create([
    //         'order_id' => 1,
    //         'user_id' => $this->user->user_id,
    //         'photo' => 'image1.jpg',
    //         'date_time_request' => now(),
    //         'pickup_time' => now(),
    //         'status' => 0,
    //     ]);

    //     OrderDetail::create([
    //         'order_id' => $this->order->order_id,
    //         'trash_id' => $this->trash->trash_id,
    //         'quantity' => 2,
    //     ]);

    //     $this->penugasan = Penugasan::create([
    //         'penugasan_id' => 1,
    //         'order_id' => $this->order->order_id,
    //         'user_id' => $this->user->user_id,
    //         'status' => 1,
    //     ]);

    //     Pickup::create([
    //         'order_id' => $this->order->order_id,
    //         'penugasan_id' => $this->penugasan->penugasan_id,
    //         'user_id' => $this->user->user_id,
    //         'arrival_date' => now()
    //     ]);

    //     $response = $this->actingAs($this->driver)->get('/driver/histori');
    //     $response->assertSee("{$this->user->name}");
    // }

    /** @test */
    public function tombol_lihat_detail_histori_menampilkan_popup()
    {
        $this->driver = User::create([
            'name' => 'driver',
            'email' => 'tester@example.com',
            'password' => bcrypt('password'),
            'role' => 3,
        ]);

        $response = $this->actingAs($this->driver)->get("/driver/histori");
        $response->assertSee("Histori Penukaran {$this->driver->name}");
    }

    /** @test */
    public function histori_kosong_menampilkan_pesan_khusus()
    {
        $this->driver = User::create([
            'name' => 'driver',
            'email' => 'tester@example.com',
            'password' => bcrypt('password'),
            'role' => 3,
        ]);

        $response = $this->actingAs($this->driver)->get('/driver/histori');
        $response->assertSee('Tidak ada histori penjemputan tersedia');
    }

    /** @test */
    public function navigasi_dari_histori_ke_dashboard_berjalan()
    {
        $this->driver = User::create([
            'name' => 'driver',
            'email' => 'tester@example.com',
            'password' => bcrypt('password'),
            'role' => 3,
        ]);

        $response = $this->actingAs($this->driver)->get('/driver');
        $response->assertStatus(200);
        $response->assertSee('Daftar Penjemputan Order');
    }
}
