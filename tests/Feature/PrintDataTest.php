<?php

namespace Tests\Feature;

use App\Models\Approval;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Pickup;
use App\Models\Trash;
use App\Models\User;
use App\Models\Withdrawal;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class PrintDataTest extends TestCase
{
    use RefreshDatabase;
    protected $admin, $driver, $trash, $order, $user;

    /** @test */
    public function test_admin_can_open_print_data_page()
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

        $response = $this->actingAs($this->admin)->get('admin/print-data');

        $response->assertStatus(200)
                 ->assertSee('Tanggal Mulai')
                 ->assertSee('Tanggal Akhir')
                 ->assertSee('Kategori')
                 ->assertSee('Tampilkan');
    }

    /** @test */
    public function test_preview_shows_default_banner_when_no_filter()
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

        $response = $this->actingAs($this->admin)->get('admin/print-data');

        $response->assertSee('Pilih Kategori');
    }

    /** @test */
    public function test_invalid_date_range_returns_error_message()
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

    $payload = [
        '_token'     => csrf_token(),
        'start_date' => '2025-07-20',
        'end_date'   => '2025-07-10',
        'category'   => 'order',
    ];

    $response = $this->actingAs($this->admin)
                    ->from(route('admin.print-data.index'))
                    ->post(route('admin.print-data.filter'), $payload);

    $response->assertRedirect(route('admin.print-data.index'));
    $response->assertSessionHasAll([
        'start_date' => '2025-07-20',
        'end_date' => '2025-07-10',
        'category' => 'order',
    ]);
    }

    /** @test */
    public function test_category_dropdown_contains_expected_options()
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

        $response = $this->actingAs($this->admin)->get('admin/print-data');

        $response->assertSee('Sampah')
                 ->assertSee('Penarikan');
    }

    /** @test */
    public function test_preview_waste_category_shows_table()
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

        Pickup::factory()->create(['order_id' => $this->order->order_id]);

        Approval::factory()->create([
            'order_id' => $this->order->order_id,
            'approval_status' => 1,
            'date_time' => '2025-07-15',
        ]);

        $response = $this->actingAs($this->admin)
            ->withSession([
                'start_date' => '2025-07-10',
                'end_date'   => '2025-07-20',
                'category'   => 'order',
            ])
            ->get(route('admin.print-data.index'));

        $response->assertStatus(200);
        $response->assertSee('Nama Sampah');
        $response->assertSee('Botol Plastik');
    }


    /** @test */
    public function test_preview_withdraw_category_shows_table()
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

        Withdrawal::create([
            'user_id' => $this->user->user_id,
            'number' => '1234567890',
            'bank' => 'BCA',
            'withdrawal_balance' => 100000,
            'datetime' => '2025-07-12 10:00:00',
        ]);

        $payload = [
            'start_date' => '2025-07-01',
            'end_date'   => '2025-07-31',
            'category'   => 'Withdraw',
        ];

        $response = $this->actingAs($this->admin)
                        ->post('admin/print-data/preview', $payload);

        $response->assertSee('Bank')
                ->assertSee('BCA')
                ->assertSee('Total Withdraw');
    }


    /** @test */
    public function test_preview_no_data_shows_not_found_message()
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

        $payload = [
            'start_date' => '2024-01-01',
            'end_date'   => '2024-01-31',
            'category'   => 'Sampah',
        ];

        $response = $this->actingAs($this->admin)
                         ->post('admin/print-data/preview', $payload);

        $response->assertSee('Tidak ada data pada rentang tersebut');
    }

    /** @test */
    public function test_header_date_is_today()
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

        Carbon::setTestNow('2025-07-16');

        $response = $this->actingAs($this->admin)->get('admin/print-data');

        $response->assertSee('16/07/2025');
    }

    /** @test */
    public function test_print_button_visible_after_preview()
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

        Trash::factory()->create(['name' => 'test']);
        $payload = [
            'start_date' => '2025-07-10',
            'end_date'   => '2025-07-20',
            'category'   => 'Sampah',
        ];

        $response = $this->actingAs($this->admin)
                         ->post('admin/print-data/preview', $payload);

        $response->assertSee('Print');
    }

    /** @test */
    public function test_print_route_returns_ok()
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

        $response = $this->actingAs($this->admin)
            ->withSession([
                'start_date' => '2025-07-01',
                'end_date' => '2025-07-31',
                'category' => 'order',
            ])
            ->get(route('admin.print-data.index'));

        $response->assertStatus(200)
                ->assertSee('Sapu Jagat, Inc.');
    }


    /** @test */
    public function test_company_header_information_displayed()
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

    $response = $this->actingAs($this->admin)
        ->withSession([
            'category' => 'order',
            'start_date' => '2025-07-01',
            'end_date' => '2025-07-31',
        ])
        ->get('/admin/print-data');

    $response->assertStatus(200)
             ->assertSee('Sapu Jagat, Inc.')
             ->assertSee('Phone')
             ->assertSee($this->admin->email);
}



    /** @test */
    public function test_reset_filter_returns_to_default_banner()
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

        $payload = [
            'start_date' => '2025-07-10',
            'end_date'   => '2025-07-20',
            'category'   => 'Sampah',
        ];
        $this->actingAs($this->admin)->post('admin/print-data/preview', $payload);

        $response = $this->actingAs($this->admin)->get('admin/print-data?reset=1');

        $response->assertSee('Pilih Kategori');
    }
}
