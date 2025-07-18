<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LaporanAdminTest extends TestCase
{
    use RefreshDatabase;

    private function admin()
    {
        return User::factory()->create(['role' => 'admin']);
    }

    /* RP‑001 ─ Halaman Laporan dapat dimuat */
    public function test_admin_can_open_laporan_page()
    {
        $response = $this->actingAs($this->admin())->get('/laporan');

        $response->assertStatus(200)
                 ->assertSee('Daftar Laporan dari Pengguna');
    }

    /* RP‑002 ─ Tabel menampilkan laporan aktif */
    public function test_table_shows_report_rows()
    {
        $report = Report::factory()->create(['status' => 'RESPONDED', 'content' => 'Sampah tidak diambil']);

        $response = $this->actingAs($this->admin())->get('/laporan');

        $response->assertSee($report->id)
                 ->assertSee('Sampah tidak diambil');
    }

    /* RP‑003 ─ Badge "Sudah Direspon" */
    public function test_status_badge_sudah_direspon()
    {
        Report::factory()->create(['status' => 'RESPONDED']);

        $response = $this->actingAs($this->admin())->get('/laporan');

        $response->assertSee('Sudah Direspon');
    }

    /* RP‑004 ─ Badge "Belum Direspon" */
    public function test_status_badge_belum_direspon()
    {
        Report::factory()->create(['status' => 'PENDING']);

        $response = $this->actingAs($this->admin())->get('/laporan');

        $response->assertSee('Belum Direspon');
    }

    /* RP‑005 ─ Tanggal direspon kosong jika pending */
    public function test_responded_at_is_dash_when_pending()
    {
        Report::factory()->create(['status' => 'PENDING', 'responded_at' => null]);

        $response = $this->actingAs($this->admin())->get('/laporan');

        $response->assertSee('-');   // asumsi tanda '-' dipakai
    }

    /* RP‑006 ─ Tombol detail membuka halaman detail */
    public function test_detail_button_opens_report_detail()
    {
        $report = Report::factory()->create();

        $response = $this->actingAs($this->admin())->get("/laporan/{$report->id}");

        $response->assertStatus(200)
                 ->assertSee($report->content);
    }

    /* RP‑007 ─ Pencarian filter */
    public function test_search_filter_reports()
    {
        Report::factory()->create(['content' => 'driver tidak ramah']);
        Report::factory()->create(['content' => 'lambat']);

        $response = $this->actingAs($this->admin())->get('/laporan?search=ramah');

        $response->assertSee('driver tidak ramah')
                 ->assertDontSee('lambat');
    }

    /* RP‑008 ─ Pagination maksimal 10 entri */
    public function test_first_page_has_max_10_rows()
    {
        Report::factory()->count(11)->create();

        $response = $this->actingAs($this->admin())->get('/laporan');

        $this->assertCount(10, $response->viewData('reports'));
    }

    /* RP‑009 ─ Next / Previous pagination */
    public function test_pagination_next_and_previous_work()
    {
        Report::factory()->count(15)->create();
        $admin = $this->admin();

        $page1 = $this->actingAs($admin)->get('/laporan?page=1');
        $page1->assertSee('?page=2');

        $page2 = $this->actingAs($admin)->get('/laporan?page=2');
        $page2->assertSee('?page=1');
    }

    /* RP‑010 ─ Status berubah ke "Sudah Direspon" setelah admin balas */
    public function test_admin_can_mark_report_as_responded()
    {
        $report = Report::factory()->create(['status' => 'PENDING', 'responded_at' => null]);

        Carbon::setTestNow(now());
        $this->actingAs($this->admin())
            ->patch("/laporan/{$report->id}", ['status' => 'RESPONDED']);

        $this->assertDatabaseHas('reports', [
            'id'          => $report->id,
            'status'      => 'RESPONDED',
            'responded_at'=> now(),
        ]);
    }
}
