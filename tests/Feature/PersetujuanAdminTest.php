<?php

namespace Tests\Feature;

use App\Models\Approval;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Pickup;
use App\Models\Trash;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class PersetujuanAdminTest extends TestCase
{
    use RefreshDatabase;

    protected $admin, $driver, $trash, $order, $user;

    /** @test */
    public function test_admin_can_open_persetujuan_page()
    {
        $this->admin = User::create([
            'user_id' => 1,
            'name' => 'Admin Sapu Jagat',
            'email' => 'driver@example.com',
            'password' => bcrypt('password'),
            'role' => 2,
        ]);

        $response = $this->actingAs($this->admin)->get('admin/persetujuan');

        $response->assertStatus(200)
                 ->assertSee('Daftar Transaksi')
                 ->assertSee('Transaksi Disetujui')
                 ->assertSee('Transaksi Ditolak')
                 ->assertSee('Penukaran Hari Ini');
    }

    /** @test */
    public function test_card_approved_count_is_correct()
    {
        $this->driver = User::create([
            'user_id' => 2,
            'name' => 'Driver Sapu Jagat',
            'address' => 'Jl.Kanak-kanak',
            'email' => 'driver1@example.com',
            'password' => bcrypt('password'),
            'role' => 3,
        ]);

        $this->admin = User::create([
            'user_id' => 1,
            'name' => 'Admin Sapu Jagat',
            'address' => 'Jl.Kanak-kanak',
            'email' => 'driver@example.com',
            'password' => bcrypt('password'),
            'role' => 2,
        ]);

        $this->user = User::create([
            'user_id' => 3,
            'name' => 'User Sapu Jagat',
            'email' => 'driver3@example.com',
            'address' => 'Jl.Kanak-kanak',
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

        UserInfo::create([
            'user_id' => $this->user->user_id,
            'address' => 'Jl. Kekanak-kanakan No.2',
            'province' => 'Jawa Timur',
            'city' => 'Jambi',
            'postal_code' => '40382',
            'balance' => '30000'
        ]);

        Approval::factory()->create([
            'order_id' => $this->order->order_id,
            'approval_status' => 2,
        ]);

        PickUp::factory()->create([
            'order_id' => $this->order->order_id,
        ]);

        for ($i = 0; $i < 3; $i++) {
            $order = Order::factory()->create();

            Approval::factory()->create([
                'order_id' => $order->order_id,
                'approval_status' => 1,
            ]);

            PickUp::factory()->create([
                'order_id' => $order->order_id,
            ]);
        }

        for ($i = 0; $i < 2; $i++) {
            $order = Order::factory()->create();

            Approval::factory()->create([
                'order_id' => $order->order_id,
                'approval_status' => 0,
            ]);

            PickUp::factory()->create([
                'order_id' => $order->order_id,
            ]);
        }

        $response = $this->actingAs($this->admin)->get('admin/persetujuan');

        $response->assertSeeInOrder([
            'Transaksi Disetujui',
            '3'
        ]);
    }

    /** @test */
    public function test_card_rejected_count_is_correct()
    {

        $this->driver = User::create([
            'user_id' => 2,
            'name' => 'Driver Sapu Jagat',
            'address' => 'Jl.Kanak-kanak',
            'email' => 'driver1@example.com',
            'password' => bcrypt('password'),
            'role' => 3,
        ]);

        $this->admin = User::create([
            'user_id' => 1,
            'name' => 'Admin Sapu Jagat',
            'address' => 'Jl.Kanak-kanak',
            'email' => 'driver@example.com',
            'password' => bcrypt('password'),
            'role' => 2,
        ]);

        $this->user = User::create([
            'user_id' => 3,
            'name' => 'User Sapu Jagat',
            'email' => 'driver3@example.com',
            'address' => 'Jl.Kanak-kanak',
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

        UserInfo::create([
            'user_id' => $this->user->user_id,
            'address' => 'Jl. Kekanak-kanakan No.2',
            'province' => 'Jawa Timur',
            'city' => 'Jambi',
            'postal_code' => '40382',
            'balance' => '30000'
        ]);

        Approval::factory()->create([
            'order_id' => $this->order->order_id,
            'approval_status' => 2,
        ]);

        PickUp::factory()->create([
            'order_id' => $this->order->order_id,
        ]);

        for ($i = 0; $i < 2; $i++) {
            $order = Order::factory()->create();

            Approval::factory()->create([
                'order_id' => $order->order_id,
                'approval_status' => 0,
            ]);

            PickUp::factory()->create([
                'order_id' => $order->order_id,
            ]);
        }

        $response = $this->actingAs($this->admin)->get('/admin/persetujuan');

        $response->assertSeeInOrder([
            'Transaksi Ditolak',
            '2'
        ]);
    }

    /** @test */
    public function test_card_today_exchange_count()
    {
        $this->driver = User::create([
            'user_id' => 2,
            'name' => 'Driver Sapu Jagat',
            'address' => 'Jl.Kanak-kanak',
            'email' => 'driver1@example.com',
            'password' => bcrypt('password'),
            'role' => 3,
        ]);

        $this->admin = User::create([
            'user_id' => 1,
            'name' => 'Admin Sapu Jagat',
            'address' => 'Jl.Kanak-kanak',
            'email' => 'driver@example.com',
            'password' => bcrypt('password'),
            'role' => 2,
        ]);

        $this->user = User::create([
            'user_id' => 3,
            'name' => 'User Sapu Jagat',
            'email' => 'driver3@example.com',
            'address' => 'Jl.Kanak-kanak',
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

        UserInfo::create([
            'user_id' => $this->user->user_id,
            'address' => 'Jl. Kekanak-kanakan No.2',
            'province' => 'Jawa Timur',
            'city' => 'Jambi',
            'postal_code' => '40382',
            'balance' => '30000'
        ]);

        Approval::factory()->create([
            'order_id' => $this->order->order_id,
            'approval_status' => 2,
        ]);

        PickUp::factory()->create([
            'order_id' => $this->order->order_id,
        ]);

        for ($i = 0; $i < 2; $i++) {
            $order = Order::factory()->create([
                'date_time_request' => now(),
            ]);

            PickUp::factory()->create([
                'order_id' => $order->order_id,
            ]);
        }

        $orderYesterday = Order::factory()->create([
            'date_time_request' => now()->subDay(),
        ]);

        PickUp::factory()->create([
            'order_id' => $orderYesterday->order_id,
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/persetujuan');

        $response->assertSeeInOrder([
            'Penukaran Hari Ini',
            '2'
        ]);
    }

    /** @test */
    public function test_table_shows_pending_transactions()
    {
        $this->driver = User::create([
            'user_id' => 2,
            'name' => 'Driver Sapu Jagat',
            'address' => 'Jl.Kanak-kanak',
            'email' => 'driver1@example.com',
            'password' => bcrypt('password'),
            'role' => 3,
        ]);

        $this->admin = User::create([
            'user_id' => 1,
            'name' => 'Admin Sapu Jagat',
            'address' => 'Jl.Kanak-kanak',
            'email' => 'driver@example.com',
            'password' => bcrypt('password'),
            'role' => 2,
        ]);

        $this->user = User::create([
            'user_id' => 3,
            'name' => 'User Sapu Jagat',
            'email' => 'driver3@example.com',
            'address' => 'Jl.Kanak-kanak',
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

        UserInfo::create([
            'user_id' => $this->user->user_id,
            'address' => 'Jl. Kekanak-kanakan No.2',
            'province' => 'Jawa Timur',
            'city' => 'Jambi',
            'postal_code' => '40382',
            'balance' => '30000'
        ]);

        Approval::factory()->create([
            'order_id' => $this->order->order_id,
            'approval_status' => 2,
        ]);

        PickUp::factory()->create([
            'order_id' => $this->order->order_id,
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/persetujuan');

        $response->assertSee('Pending');
        $response->assertSee('Botol Plastik');
    }

    /** @test */
    public function test_admin_can_approve_transaction()
    {
        $this->driver = User::create([
            'user_id' => 2,
            'name' => 'Driver Sapu Jagat',
            'address' => 'Jl.Kanak-kanak',
            'email' => 'driver1@example.com',
            'password' => bcrypt('password'),
            'role' => 3,
        ]);

        $this->admin = User::create([
            'user_id' => 1,
            'name' => 'Admin Sapu Jagat',
            'address' => 'Jl.Kanak-kanak',
            'email' => 'driver@example.com',
            'password' => bcrypt('password'),
            'role' => 2,
        ]);

        $this->user = User::create([
            'user_id' => 3,
            'name' => 'User Sapu Jagat',
            'email' => 'driver3@example.com',
            'address' => 'Jl.Kanak-kanak',
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

        UserInfo::create([
            'user_id' => $this->user->user_id,
            'address' => 'Jl. Kekanak-kanakan No.2',
            'province' => 'Jawa Timur',
            'city' => 'Jambi',
            'postal_code' => '40382',
            'balance' => '30000'
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.persetujuan.store'), [
            '_token'          => csrf_token(),
            'order_id'        => $this->order->order_id,
            'user_id'         => $this->user->user_id,
            'approval_status' => 1,
            'notes'           => 'Disetujui oleh admin',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('approvals', [
            'order_id'        => $this->order->order_id,
            'user_id'         => $this->user->user_id,
            'approval_status' => 1,
            'notes'           => 'Disetujui oleh admin',
        ]);
    }


    /** @test */
    public function test_admin_can_reject_transaction()
    {
        Session::start();

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

        $response = $this->withoutExceptionHandling()->actingAs($this->admin)->post(route('admin.persetujuan.store'), [
            '_token'          => csrf_token(),
            'order_id'        => $this->order->order_id,
            'user_id'         => $this->user->user_id,
            'approval_status' => 0,
            'notes'           => 'Ditolak oleh admin',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('approvals', [
            'order_id'        => $this->order->order_id,
            'user_id'         => $this->user->user_id,
            'approval_status' => 0,
            'notes'           => 'Ditolak oleh admin',
        ]);
    }


    /** @test */
    public function test_admin_can_keep_transaction_pending()
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

        $response = $this->withoutExceptionHandling()->actingAs($this->admin)->post(route('admin.persetujuan.store'), [
            '_token'          => csrf_token(),
            'order_id'        => $this->order->order_id,
            'user_id'         => $this->user->user_id,
            'approval_status' => 2,
            'notes'           => 'Dipending oleh admin',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('approvals', [
            'order_id'        => $this->order->order_id,
            'user_id'         => $this->user->user_id,
            'approval_status' => 2,
            'notes'           => 'Dipending oleh admin',
        ]);
    }
}
