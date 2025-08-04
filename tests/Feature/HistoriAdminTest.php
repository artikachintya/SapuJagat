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

class HistoriAdminTest extends TestCase
{
    use RefreshDatabase;
    protected $admin, $driver, $trash, $order, $user;

    /** @test */
    public function test_admin_can_open_histori_page()
    {
        $this->admin = User::create([
            'name' => 'Admin Sapu Jagat',
            'email' => 'driver@example.com',
            'password' => bcrypt('password'),
            'role' => 2,
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/histori');
        $response->assertStatus(200)
                ->assertSee('Histori Penukaran Pengguna');
    }

    /** @test */
    public function test_table_shows_histori_rows()
    {
        $this->admin = User::create([
            'user_id' => 1,
            'name' => 'Admin Sapu Jagat',
            'email' => 'driver@example.com',
            'password' => bcrypt('password'),
            'role' => 2,
        ]);

        $this->user = User::create([
            'user_id' => 3,
            'name' => 'User Sapu Jagat',
            'email' => 'driver3@example.com',
            'password' => bcrypt('password'),
            'role' => 1,
        ]);

        $this->trash = Trash::create([
            'name' => 'Botol Plastik',
            'type' => 'Anorganik',
            'photos' => 'image1.jpg',
            'price_per_kg' => 4300,
        ]);

        $this->order = Order::create([
            'user_id' => $this->user->user_id,
            'photo' => 'image1.jpg',
            'date_time_request' => now(),
            'pickup_time' => now(),
            'status' => 1,
        ]);

        OrderDetail::create([
            'order_id' => $this->order->order_id,
            'trash_id' => $this->trash->trash_id,
            'quantity' => 2,
        ]);


        $response = $this->actingAs($this->admin)->get(route('admin.histori.index'));

        $response->assertStatus(200)
                ->assertSee('Botol Plastik');
    }

    /** @test */
    public function test_status_dalam_proses_badge_exists()
    {
        $this->admin = User::create([
            'user_id' => 1,
            'name' => 'Admin Sapu Jagat',
            'email' => 'driver@example.com',
            'password' => bcrypt('password'),
            'role' => 2,
        ]);

        $this->user = User::create([
            'user_id' => 3,
            'name' => 'User Sapu Jagat',
            'email' => 'driver3@example.com',
            'password' => bcrypt('password'),
            'role' => 1,
        ]);

        $this->trash = Trash::create([
            'name' => 'Plastik',
            'type' => 'Anorganik',
            'photos' => 'image1.jpg',
            'price_per_kg' => 4300,
        ]);

        $this->order = Order::create([
            'user_id' => $this->user->user_id,
            'photo' => 'image1.jpg',
            'date_time_request' => now(),
            'pickup_time' => now(),
            'status' => 1,
        ]);

        OrderDetail::create([
            'order_id' => $this->order->order_id,
            'trash_id' => $this->trash->trash_id,
            'quantity' => 2,
        ]);

        Approval::factory()->create([
            'user_id' => $this->user->user_id,
            'order_id' => $this->order->order_id,
            'approval_status' => 2,
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.histori.index'));

        $response->assertStatus(200);
        $response->assertSee('Dalam Proses');
    }

    /** @test */
    public function test_status_belum_persetujuan_badge_exists()
    {
        $this->admin = User::create([
            'user_id' => 1,
            'name' => 'Admin Sapu Jagat',
            'email' => 'driver@example.com',
            'password' => bcrypt('password'),
            'role' => 2,
        ]);

        $this->user = User::create([
            'user_id' => 3,
            'name' => 'User Sapu Jagat',
            'email' => 'driver3@example.com',
            'password' => bcrypt('password'),
            'role' => 1,
        ]);

        $this->trash = Trash::create([
            'name' => 'Plastik',
            'type' => 'Anorganik',
            'photos' => 'image1.jpg',
            'price_per_kg' => 4300,
        ]);

        $this->order = Order::create([
            'user_id' => $this->user->user_id,
            'photo' => 'image1.jpg',
            'date_time_request' => now(),
            'pickup_time' => now(),
            'status' => 1,
        ]);

        OrderDetail::create([
            'order_id' => $this->order->order_id,
            'trash_id' => $this->trash->trash_id,
            'quantity' => 2,
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.histori.index'));

        $response->assertStatus(200);
        $response->assertSee('Belum Ada Persetujuan');
    }

    /** @test */
    public function test_tanggal_disetujui_shown_for_approved()
    {
        $this->admin = User::create([
            'user_id' => 1,
            'name' => 'Admin Sapu Jagat',
            'email' => 'driver@example.com',
            'password' => bcrypt('password'),
            'role' => 2,
        ]);

        $this->user = User::create([
            'user_id' => 3,
            'name' => 'User Sapu Jagat',
            'email' => 'driver3@example.com',
            'password' => bcrypt('password'),
            'role' => 1,
        ]);

        $this->trash = Trash::create([
            'name' => 'Plastik',
            'type' => 'Anorganik',
            'photos' => 'image1.jpg',
            'price_per_kg' => 4300,
        ]);

        $this->order = Order::create([
            'user_id' => $this->user->user_id,
            'photo' => 'image1.jpg',
            'date_time_request' => now(),
            'pickup_time' => now(),
            'status' => 1,
        ]);

        OrderDetail::create([
            'order_id' => $this->order->order_id,
            'trash_id' => $this->trash->trash_id,
            'quantity' => 2,
        ]);

        $approvedAt = now();

        Approval::factory()->create([
            'user_id' => $this->user->user_id,
            'order_id'          => $this->order->order_id,
            'approval_status'            => 1,
            'date_time' => $approvedAt,
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/histori');
        $response->assertSee($approvedAt->format('Y-m-d H:i'));
    }

    /** @test */
    public function test_tanggal_selesai_empty_when_null()
    {
        $this->admin = User::create([
            'user_id' => 1,
            'name' => 'Admin Sapu Jagat',
            'email' => 'driver@example.com',
            'password' => bcrypt('password'),
            'role' => 2,
        ]);

        $this->user = User::create([
            'user_id' => 3,
            'name' => 'User Sapu Jagat',
            'email' => 'driver3@example.com',
            'password' => bcrypt('password'),
            'role' => 1,
        ]);

        $this->trash = Trash::create([
            'name' => 'Plastik',
            'type' => 'Anorganik',
            'photos' => 'image1.jpg',
            'price_per_kg' => 4300,
        ]);

        $this->order = Order::create([
            'user_id' => $this->user->user_id,
            'photo' => 'image1.jpg',
            'date_time_request' => now(),
            'pickup_time' => now(),
            'status' => 1,
        ]);

        OrderDetail::create([
            'order_id' => $this->order->order_id,
            'trash_id' => $this->trash->trash_id,
            'quantity' => 2,
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/histori');

        $response->assertSee('-');
    }

    /** @test */
    public function test_biaya_formatted_as_currency()
    {
        $this->admin = User::create([
            'user_id' => 1,
            'name' => 'Admin Sapu Jagat',
            'email' => 'driver@example.com',
            'password' => bcrypt('password'),
            'role' => 2,
        ]);

        $this->user = User::create([
            'user_id' => 3,
            'name' => 'User Sapu Jagat',
            'email' => 'driver3@example.com',
            'password' => bcrypt('password'),
            'role' => 1,
        ]);

        $this->trash = Trash::create([
            'name' => 'Plastik',
            'type' => 'Anorganik',
            'photos' => 'image1.jpg',
            'price_per_kg' => 4300,
        ]);

        $this->order = Order::create([
            'user_id' => $this->user->user_id,
            'photo' => 'image1.jpg',
            'date_time_request' => now(),
            'pickup_time' => now(),
            'status' => 1,
        ]);

        OrderDetail::create([
            'order_id' => $this->order->order_id,
            'trash_id' => $this->trash->trash_id,
            'quantity' => 2,
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/histori');

        $response->assertSee('Rp8.600');
    }

    /** @test */
    public function test_detail_button_route()
    {
        $this->admin = User::create([
            'user_id' => 1,
            'name' => 'Admin Sapu Jagat',
            'email' => 'driver@example.com',
            'password' => bcrypt('password'),
            'role' => 2,
        ]);

        $this->user = User::create([
            'user_id' => 3,
            'name' => 'User Sapu Jagat',
            'email' => 'driver3@example.com',
            'password' => bcrypt('password'),
            'role' => 1,
        ]);

        $this->trash = Trash::create([
            'name' => 'Plastik',
            'type' => 'Anorganik',
            'photos' => 'image1.jpg'
        ]);

        $this->order = Order::create([
            'user_id' => $this->user->user_id,
            'photo' => 'image1.jpg',
            'date_time_request' => now(),
            'pickup_time' => now(),
            'status' => 1,
        ]);

        OrderDetail::create([
            'order_id' => $this->order->order_id,
            'trash_id' => $this->trash->trash_id,
            'quantity' => 5,
        ]);

        $response = $this->actingAs($this->admin)->get("/admin/histori");

        $response->assertStatus(200)
                ->assertSee('Plastik');
    }

    /** @test */
    public function test_driver_cannot_access_histori_page()
    {
        $this->driver = User::create([
            'name' => 'Driver Sapu Jagat',
            'email' => 'driver@example.com',
            'password' => bcrypt('password'),
            'role' => 3,
        ]);

        $response = $this->actingAs($this->driver)->get('admin/histori');
        $response->assertStatus(403);
    }
}
