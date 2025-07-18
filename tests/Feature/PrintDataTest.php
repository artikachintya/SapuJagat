<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PrintDataTest extends TestCase
{
    use RefreshDatabase;

    private function admin()
    {
        return User::factory()->create(['role' => 'admin']);
    }

    /* PD‑001 ─ Halaman Print‑Data dapat dimuat */
    public function test_admin_can_open_print_data_page()
    {
        $response = $this->actingAs($this->admin())->get('/print-data');

        $response->assertStatus(200)
                 ->assertSee('Start Date')
                 ->assertSee('End Date')
                 ->assertSee('Kategori')
                 ->assertSee('Tampilkan');
    }

    /* PD‑002 ─ Tombol Tampilkan non‑aktif (banner default) */
    public function test_preview_shows_default_banner_when_no_filter()
    {
        $response = $this->actingAs($this->admin())->get('/print-data');

        $response->assertSee('Silakan pilih kategori di atas');
    }

    /* PD‑003 ─ Validasi rentang tanggal salah */
    public function test_invalid_date_range_returns_error_message()
    {
        $payload = [
            'start_date' => '2025-07-20',
            'end_date'   => '2025-07-10',   // lebih kecil
            'category'   => 'Sampah',
        ];

        $response = $this->actingAs($this->admin())
                         ->post('/print-data/preview', $payload);

        $response->assertSessionHasErrors()               // redirect back dgn error
                 ->assertInvalid('start_date');
    }

    /* PD‑004 ─ Dropdown kategori memuat semua opsi */
    public function test_category_dropdown_contains_expected_options()
    {
        $response = $this->actingAs($this->admin())->get('/print-data');

        $response->assertSee('Sampah')
                 ->assertSee('Withdraw')
                 ->assertSee('Penugasan');  // tambahkan opsi lain jika ada
    }

    /* PD‑005 ─ Kategori Sampah menampilkan tabel rekap */
    public function test_preview_waste_category_shows_table()
    {
        Waste::factory()->create(['nama' => 'Botol Plastik', 'created_at' => '2025-07-15']);

        $payload = [
            'start_date' => '2025-07-10',
            'end_date'   => '2025-07-20',
            'category'   => 'Sampah',
        ];

        $response = $this->actingAs($this->admin())
                         ->post('/print-data/preview', $payload);

        $response->assertSee('Nama Sampah')
                 ->assertSee('Botol Plastik');
    }

    /* PD‑006 ─ Kategori Withdraw menampilkan tabel */
    public function test_preview_withdraw_category_shows_table()
    {
        Withdraw::factory()->create(['bank' => 'BCA', 'total' => 100000, 'created_at' => '2025-07-12']);

        $payload = [
            'start_date' => '2025-07-01',
            'end_date'   => '2025-07-31',
            'category'   => 'Withdraw',
        ];

        $response = $this->actingAs($this->admin())
                         ->post('/print-data/preview', $payload);

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
                         ->post('/print-data/preview', $payload);

        $response->assertSee('Tidak ada data pada rentang tersebut');
    }

    /* PD‑008 ─ Tanggal header = hari ini */
    public function test_header_date_is_today()
    {
        Carbon::setTestNow('2025-07-16');

        $response = $this->actingAs($this->admin())->get('/print-data');

        $response->assertSee('16/07/2025');
    }

    /* PD‑009 ─ Tombol Print muncul setelah data ditampilkan */
    public function test_print_button_visible_after_preview()
    {
        Waste::factory()->create(['created_at' => '2025-07-15']);
        $payload = [
            'start_date' => '2025-07-10',
            'end_date'   => '2025-07-20',
            'category'   => 'Sampah',
        ];

        $response = $this->actingAs($this->admin())
                         ->post('/print-data/preview', $payload);

        $response->assertSee('Print');
    }

    /* PD‑010 ─ Simulasi klik Print (cek route /print) */
    public function test_print_route_returns_ok()
    {
        $response = $this->actingAs($this->admin())->get('/print-data/print');

        $response->assertStatus(200)
                 ->assertSee('window.print');
    }

    /* PD‑011 ─ Header perusahaan & kontak muncul */
    public function test_company_header_information_displayed()
    {
        $response = $this->actingAs($this->admin())->get('/print-data');

        $response->assertSee('Sapu Jagat, Inc.')
                 ->assertSee('Phone')
                 ->assertSee($this->admin()->email);
    }

    /* PD‑012 ─ Reset filter mengembalikan banner default */
    public function test_reset_filter_returns_to_default_banner()
    {
        // Step 1: preview with data
        Waste::factory()->create(['created_at' => '2025-07-15']);
        $payload = [
            'start_date' => '2025-07-10',
            'end_date'   => '2025-07-20',
            'category'   => 'Sampah',
        ];
        $this->actingAs($this->admin())->post('/print-data/preview', $payload);

        // Step 2: akses ulang halaman tanpa session preview (reset)
        $response = $this->actingAs($this->admin())->get('/print-data?reset=1');

        $response->assertSee('Silakan pilih kategori di atas');
    }
}
