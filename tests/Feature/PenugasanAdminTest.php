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
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class PenugasanAdminTest extends TestCase
{
    use RefreshDatabase;
    protected $admin, $driver, $trash, $order, $user;

    /** @test */
    public function test_admin_can_open_penugasan_page()
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

        $response = $this->actingAs($this->admin)->get('admin/penugasan');

        $response->assertStatus(200)
                ->assertSee('Penugasan');
    }

    /** @test */
    public function test_table_shows_orders_without_driver()
    {
        $this->driver = User::create([
            'user_id' => 2,
            'name' => 'Driver Sapu Jagat',
            'email' => 'driver1@example.com',
            'password' => bcrypt('password'),
            'role' => 3,
        ]);

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

        $response = $this->actingAs($this->admin)->get('admin/penugasan');

        $response->assertStatus(200);
        $response->assertSee((string) $this->order->order_id);

        $response->assertSee('Belum Ada');
    }

    /** @test */
    public function test_driver_column_shows_belum_ada()
    {
        $this->driver = User::create([
            'user_id' => 2,
            'name' => 'Driver Sapu Jagat',
            'email' => 'driver1@example.com',
            'password' => bcrypt('password'),
            'role' => 3,
        ]);

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

        $response = $this->actingAs($this->admin)->get('admin/penugasan');

        $response->assertStatus(200);
        $response->assertSee((string) $this->order->order_id);
        $response->assertSee('Belum Ada');
    }


    /** @test */
    public function test_status_column_shows_belum_ada()
    {
        $this->driver = User::create([
            'user_id' => 2,
            'name' => 'Driver Sapu Jagat',
            'email' => 'driver1@example.com',
            'password' => bcrypt('password'),
            'role' => 3,
        ]);

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

        $response = $this->actingAs($this->admin)->get('admin/penugasan');

        $response->assertStatus(200);
        $response->assertSee((string) $this->order->order_id);
        $response->assertSee('Belum Ada');
    }


    /** @test */
    public function test_create_assignment_button_enabled_when_no_driver()
    {
        $this->driver = User::create([
            'user_id' => 2,
            'name' => 'Driver Sapu Jagat',
            'email' => 'driver1@example.com',
            'password' => bcrypt('password'),
            'role' => 3,
        ]);

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

        $response = $this->actingAs($this->admin)->get('admin/penugasan');

        $response->assertSee('Buat Penugasan');
    }

    /** @test */
    public function test_create_assignment_form_can_be_opened()
    {
        $this->driver = User::create([
            'user_id' => 2,
            'name' => 'Driver Sapu Jagat',
            'email' => 'driver1@example.com',
            'password' => bcrypt('password'),
            'role' => 3,
        ]);

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

        $response = $this->actingAs($this->admin)->get('admin/penugasan');

        $response->assertStatus(200);
        $response->assertSee('Buat Penugasan');
        $response->assertSee('Pilih Pengemudi');
    }


    /** @test */
    public function test_store_assignment_updates_driver_and_status()
{
    $this->driver = User::create([
            'user_id' => 2,
            'name' => 'Driver Sapu Jagat',
            'email' => 'driver1@example.com',
            'password' => bcrypt('password'),
            'role' => 3,
        ]);

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

    Session::start();

    $response = $this->actingAs($this->admin)
        ->post(route('admin.penugasan.store'), [
            '_token'   => csrf_token(),
            'order_id' => $this->order->order_id,
            'user_id'  => $this->driver->user_id,
        ]);


    $response->assertRedirect();

    $this->assertDatabaseHas('penugasans', [
        'order_id' => $this->order->order_id,
        'user_id'  => $this->driver->user_id,
        'status'   => 0,
    ]);

    $this->assertDatabaseHas('pick_ups', [
        'order_id' => $this->order->order_id,
        'user_id'  => $this->driver->user_id,
    ]);
}

    /** @test */
    public function test_delete_button_shown_when_assignment_exists()
    {
        $this->driver = User::create([
            'user_id' => 2,
            'name' => 'Driver Sapu Jagat',
            'email' => 'driver1@example.com',
            'password' => bcrypt('password'),
            'role' => 3,
        ]);

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

        Penugasan::factory()->create([
            'order_id' => $this->order->order_id,
            'user_id'  => $this->driver->user_id,
            'status'   => 0,
        ]);

        $response = $this->actingAs($this->admin)->get('admin/penugasan');

        $response->assertSee('Hapus Tugas');
    }
}
