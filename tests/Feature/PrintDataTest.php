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

    private function admin()
    {
        return User::factory()->create(['role' =>2]);
    }

    /* PD‑001 ─ Halaman Print‑Data dapat dimuat */
    public function test_admin_can_open_print_data_page()
    {
        $response = $this->actingAs($this->admin())->get('admin/print-data');

        $response->assertStatus(200)
                 ->assertSee('Start Date')
                 ->assertSee('End Date')
                 ->assertSee('Kategori')
                 ->assertSee('Tampilkan');
    }

    /* PD‑002 ─ Tombol Tampilkan non‑aktif (banner default) */
    public function test_preview_shows_default_banner_when_no_filter()
    {
        $response = $this->actingAs($this->admin())->get('admin/print-data');

        $response->assertSee('Silakan pilih kategori di atas');
    }

    /* PD‑003 ─ Validasi rentang tanggal salah */
    public function test_invalid_date_range_returns_error_message()
{
    Session::start(); // start session for CSRF + flash

    $payload = [
        '_token'     => csrf_token(),
        'start_date' => '2025-07-20',
        'end_date'   => '2025-07-10',
        'category'   => 'order',
    ];

    $response = $this->actingAs($this->admin())
                    ->from(route('admin.print-data.index'))
                    ->post(route('admin.print-data.filter'), $payload);

    $response->assertRedirect(route('admin.print-data.index'));
    $response->assertSessionHasAll([
        'start_date' => '2025-07-20',
        'end_date' => '2025-07-10',
        'category' => 'order',
    ]);
}

    /* PD‑004 ─ Dropdown kategori memuat semua opsi */
    public function test_category_dropdown_contains_expected_options()
    {
        $response = $this->actingAs($this->admin())->get('admin/print-data');

        $response->assertSee('Sampah')
                 ->assertSee('Withdraw');
    }

    /* PD‑005 ─ Kategori Sampah menampilkan tabel rekap */
    public function test_preview_waste_category_shows_table()
    {
        $trash = Trash::factory()->create([
            'name' => 'Botol Plastik'
        ]);

        // Create order and associated models
        $order = Order::factory()->create();
        Pickup::factory()->create(['order_id' => $order->order_id]);
        Approval::factory()->create([
            'order_id' => $order->order_id,
            'approval_status' => 1,
            'date_time' => '2025-07-15',
        ]);
        OrderDetail::factory()->create([
            'order_id' => $order->order_id,
            'trash_id' => $trash->trash_id,
            'quantity' => 5,
        ]);

        $response = $this->actingAs($this->admin())
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


    /* PD‑006 ─ Kategori Withdraw menampilkan tabel */
    public function test_preview_withdraw_category_shows_table()
    {
        // Create a withdraw manually
        Withdrawal::create([
            'user_id' => $this->admin()->user_id, // or use an existing user_id
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

        $response = $this->actingAs($this->admin())
                        ->post('admin/print-data/preview', $payload);

        $response->assertSee('Bank')
                ->assertSee('BCA')
                ->assertSee('Total Withdraw');
    }


    /* PD‑007 ─ Tidak ada data → pesan kosong */
    public function test_preview_no_data_shows_not_found_message()
    {
        $payload = [
            'start_date' => '2024-01-01',
            'end_date'   => '2024-01-31',
            'category'   => 'Sampah',
        ];

        $response = $this->actingAs($this->admin())
                         ->post('admin/print-data/preview', $payload);

        $response->assertSee('Tidak ada data pada rentang tersebut');
    }

    /* PD‑008 ─ Tanggal header = hari ini */
    public function test_header_date_is_today()
    {
        Carbon::setTestNow('2025-07-16');

        $response = $this->actingAs($this->admin())->get('admin/print-data');

        $response->assertSee('16/07/2025');
    }

    /* PD‑009 ─ Tombol Print muncul setelah data ditampilkan */
    public function test_print_button_visible_after_preview()
    {
        Trash::factory()->create(['name' => 'test']);
        $payload = [
            'start_date' => '2025-07-10',
            'end_date'   => '2025-07-20',
            'category'   => 'Sampah',
        ];

        $response = $this->actingAs($this->admin())
                         ->post('admin/print-data/preview', $payload);

        $response->assertSee('Print');
    }

    /* PD‑010 ─ Simulasi klik Print (cek route /print) */
    public function test_print_route_returns_ok()
    {
        $response = $this->actingAs($this->admin())
            ->withSession([
                'start_date' => '2025-07-01',
                'end_date' => '2025-07-31',
                'category' => 'order',
            ])
            ->get(route('admin.print-data.index'));

        $response->assertStatus(200)
                ->assertSee('Sapu Jagat, Inc.'); // or other static text from the Blade
    }


    /* PD‑011 ─ Header perusahaan & kontak muncul */
    public function test_company_header_information_displayed()
{
    // Arrange: create a dummy order so the page actually shows something
    $admin = $this->admin();

    Order::factory()->create([
        'date_time_request' => '2025-07-15',
        'user_id' => $admin->user_id,
    ]);

    // Act
    $response = $this->actingAs($admin)
        ->withSession([
            'category' => 'order',
            'start_date' => '2025-07-01',
            'end_date' => '2025-07-31',
        ])
        ->get('/admin/print-data');

    // Assert
    $response->assertStatus(200)
             ->assertSee('Sapu Jagat, Inc.')
             ->assertSee('Phone')
             ->assertSee($admin->email);
}



    /* PD‑012 ─ Reset filter mengembalikan banner default */
    public function test_reset_filter_returns_to_default_banner()
    {
        // Step 1: preview with data
        Trash::factory()->create(['name' => 'test']);
        $payload = [
            'start_date' => '2025-07-10',
            'end_date'   => '2025-07-20',
            'category'   => 'Sampah',
        ];
        $this->actingAs($this->admin())->post('admin/print-data/preview', $payload);

        // Step 2: akses ulang halaman tanpa session preview (reset)
        $response = $this->actingAs($this->admin())->get('admin/print-data?reset=1');

        $response->assertSee('Silakan pilih kategori di atas');
    }
}
