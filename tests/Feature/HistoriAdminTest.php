<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HistoriAdminTest extends TestCase
{
    use RefreshDatabase;

    /* Util */
    private function admin()
    {
        return User::factory()->create(['role' => 'admin']);
    }

    private function driver()
    {
        return User::factory()->create(['role' => 'driver']);
    }

    /* HP‑001 ─ Halaman histori dapat diakses */
    public function test_admin_can_open_histori_page()
    {
        $response = $this->actingAs($this->admin())->get('/histori');
        $response->assertStatus(200)
                 ->assertSee('Histori Penukaran Pengguna');
    }

    /* HP‑002 ─ Data histori tampil */
    public function test_table_shows_histori_rows()
    {
        Histori::factory()->create(['jenis_sampah' => 'Botol Plastik']);

        $response = $this->actingAs($this->admin())->get('/histori');
        $response->assertSee('Botol Plastik');
    }

    /* HP‑003 ─ Badge Dalam Proses oranye */
    public function test_status_dalam_proses_badge_exists()
    {
        Histori::factory()->create(['status' => 'Dalam Proses']);

        $response = $this->actingAs($this->admin())->get('/histori');
        $response->assertSee('Dalam Proses');
        // warna oranye diuji di Dusk/BrowserTest; di sini cukup text
    }

    /* HP‑004 ─ Badge Belum Ada Persetujuan */
    public function test_status_belum_persetujuan_badge_exists()
    {
        Histori::factory()->create(['status' => 'Belum Ada Persetujuan']);

        $response = $this->actingAs($this->admin())->get('/histori');
        $response->assertSee('Belum Ada Persetujuan');
    }

    /* HP‑005 ─ Kolom tanggal disetujui muncul */
    public function test_tanggal_disetujui_shown_for_approved()
    {
        $hist = Histori::factory()->create([
            'status'           => 'Disetujui',
            'tanggal_disetujui'=> now()
        ]);

        $response = $this->actingAs($this->admin())->get('/histori');
        $response->assertSee($hist->tanggal_disetujui->format('Y-m-d H:i'));
    }

    /* HP‑006 ─ Tanggal selesai kosong */
    public function test_tanggal_selesai_empty_when_null()
    {
        Histori::factory()->create(['tanggal_selesai' => null]);

        $response = $this->actingAs($this->admin())->get('/histori');
        $response->assertSee('-');   // asumsi simbol '-' utk kosong
    }

    /* HP‑007 ─ Format mata uang biaya */
    public function test_biaya_formatted_as_currency()
    {
        Histori::factory()->create(['biaya' => 8600]);

        $response = $this->actingAs($this->admin())->get('/histori');
        $response->assertSee('Rp8.600');
    }

    /* HP‑008 ─ Tombol detail redirect */
    public function test_detail_button_route()
    {
        $hist = Histori::factory()->create();
        $response = $this->actingAs($this->admin())->get("/histori/{$hist->id}");
        $response->assertStatus(200)
                 ->assertSee($hist->jenis_sampah);
    }

    /* HP‑009 ─ Search filter */
    public function test_search_filter_returns_matching_rows()
    {
        Histori::factory()->create(['jenis_sampah' => 'Kaca Pecah']);
        Histori::factory()->create(['jenis_sampah' => 'Botol Plastik']);

        $response = $this->actingAs($this->admin())
                         ->get('/histori?search=Kaca');
        $response->assertSee('Kaca Pecah')
                 ->assertDontSee('Botol Plastik');
    }

    /* HP‑010 ─ Pagination menampilkan 10 baris */
    public function test_first_page_shows_only_10_rows()
    {
        Histori::factory()->count(11)->create();

        $response = $this->actingAs($this->admin())->get('/histori');
        $this->assertCount(10, $response->viewData('histori')); // asumsi variabel view
    }

    /* HP‑011 ─ Tombol next/prev */
    public function test_next_and_previous_pagination_links()
    {
        Histori::factory()->count(12)->create();
        $admin = $this->admin();

        $page1 = $this->actingAs($admin)->get('/histori?page=1');
        $page1->assertSee('?page=2');

        $page2 = $this->actingAs($admin)->get('/histori?page=2');
        $page2->assertSee('?page=1');
    }

    /* HP‑012 ─ Role selain admin ditolak */
    public function test_driver_cannot_access_histori_page()
    {
        $response = $this->actingAs($this->driver())->get('/histori');
        $response->assertStatus(403);
    }

    /* HP‑013 ─ Sorting kolom biaya */
    public function test_sorting_biaya_order()
    {
        Histori::factory()->create(['jenis_sampah'=>'Murah', 'biaya'=>1000]);
        Histori::factory()->create(['jenis_sampah'=>'Mahal', 'biaya'=>9000]);

        $asc = $this->actingAs($this->admin())
                    ->get('/histori?sort=biaya&direction=asc');
        $this->assertEquals(
            ['Murah','Mahal'],
            $asc->viewData('histori')->pluck('jenis_sampah')->toArray()
        );

        $desc = $this->actingAs($this->admin())
                     ->get('/histori?sort=biaya&direction=desc');
        $this->assertEquals(
            ['Mahal','Murah'],
            $desc->viewData('histori')->pluck('jenis_sampah')->toArray()
        );
    }
}
