<?php

namespace Tests\Feature;

use App\Models\Report;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Response;
use Session;
use Tests\TestCase;

class LaporanAdminTest extends TestCase
{
    use RefreshDatabase;

    private function admin()
    {
        return User::factory()->create(['role' => 2]);
    }

    /* RP‑001 ─ Halaman Laporan dapat dimuat */
    public function test_admin_can_open_laporan_page()
    {
        $response = $this->actingAs($this->admin())->get('admin/laporan');

        $response->assertStatus(200)
                 ->assertSee('Daftar Laporan dari Pengguna');
    }

    /* RP‑002 ─ Tabel menampilkan laporan aktif */
    public function test_table_shows_report_rows()
    {
        $report = Report::factory()->create([
            'report_message' => 'Sampah tidak diambil',
        ]);

        $response = $this->actingAs($this->admin())->get('admin/laporan');

        $response->assertSee((string) $report->report_id)
                ->assertSee('Sampah tidak diambil');
    }


    /* RP‑003 ─ Badge "Sudah Direspon" */
    public function test_status_badge_sudah_direspon()
    {
        $admin = $this->admin();

        $report = Report::factory()->create([
            'report_message' => 'Sampah tidak diambil',
        ]);

        Response::factory()->create([
            'report_id' => $report->report_id,
            'user_id' => $admin->user_id,
            'response_message' => 'Sudah kami tindak lanjuti',
        ]);

        $response = $this->actingAs($admin)->get('admin/laporan');

        $response->assertSee((string) $report->report_id)
                ->assertSee('Sampah tidak diambil')
                ->assertSee('Sudah Direspon');
    }


    public function test_status_badge_belum_direspon()
    {
        $report = Report::factory()->create([
            'report_message' => 'Sampah masih menumpuk',
        ]);

        $response = $this->actingAs($this->admin())->get('admin/laporan');

        $response->assertSee((string) $report->report_id)
                ->assertSee('Sampah masih menumpuk')
                ->assertSee('Belum Direspon');
    }

    /* RP‑005 ─ Tanggal direspon kosong jika pending */
    public function test_responded_at_is_dash_when_pending()
    {
        // Create a report with no response
        $report = Report::factory()->create([
            'report_message' => 'Belum direspon',
        ]);

        $response = $this->actingAs($this->admin())->get('admin/laporan');

        // Ensure that dash "-" is shown in the responded_at column
        $response->assertSee((string) $report->report_id)
                ->assertSee('Belum direspon')
                ->assertSee('-');
    }

    /* RP‑006 ─ Tombol detail membuka halaman detail */
    public function test_detail_modal_contains_report_information()
    {
        $report = Report::factory()->forUser()->create([
            'report_message' => 'Ada sampah di jalan',
            'date_time_report' => now()->subDays(1),
        ]);

        $response = $this->actingAs($this->admin())->get('/admin/laporan');

        $response->assertStatus(200)
                ->assertSee("Detail Laporan #{$report->report_id}")
                ->assertSee((string) $report->user->user_id)
                ->assertSee($report->user->name)
                ->assertSee('Ada sampah di jalan')
                ->assertSee($report->date_time_report->format('Y-m-d H:i')) // Optional if formatted
                ->assertSee('Belum Direspon');
    }


    /* RP‑007 ─ Pencarian filter */
    // public function test_search_filter_reports()
    // {
    //     Report::factory()->create(['content' => 'driver tidak ramah']);
    //     Report::factory()->create(['content' => 'lambat']);

    //     $response = $this->actingAs($this->admin())->get('/laporan?search=ramah');

    //     $response->assertSee('driver tidak ramah')
    //              ->assertDontSee('lambat');
    // }

    // /* RP‑008 ─ Pagination maksimal 10 entri */
    // public function test_first_page_has_max_10_rows()
    // {
    //     Report::factory()->count(11)->create();

    //     $response = $this->actingAs($this->admin())->get('/laporan');

    //     $this->assertCount(10, $response->viewData('reports'));
    // }

    // /* RP‑009 ─ Next / Previous pagination */
    // public function test_pagination_next_and_previous_work()
    // {
    //     Report::factory()->count(15)->create();
    //     $admin = $this->admin();

    //     $page1 = $this->actingAs($admin)->get('/laporan?page=1');
    //     $page1->assertSee('?page=2');

    //     $page2 = $this->actingAs($admin)->get('/laporan?page=2');
    //     $page2->assertSee('?page=1');
    // }

    /* RP‑010 ─ Status berubah ke "Sudah Direspon" setelah admin balas */
    public function test_admin_can_mark_report_as_responded()
    {
        $admin = $this->admin(); // assume this returns a valid admin user

        $report = Report::factory()->create([
            'report_message' => 'Belum sss',
            'date_time_report' => now(),
        ]);
        Session::start();

        $response = $this->actingAs($admin)->post(route('admin.laporan.store'), [
            '_token' => csrf_token(),
            'report_id' => $report->report_id,
            'user_id' => $admin->user_id,
            'response_message' => 'Terima kasih atas laporannya.',
        ]);

        $response->assertRedirect(route('admin.laporan.index'));
        $response->assertSessionHas('success', 'Respon berhasil dikirim.');

        // Assert response saved
        $this->assertDatabaseHas('responses', [
            'report_id' => $report->report_id,
            'user_id' => $admin->user_id,
            'response_message' => 'Terima kasih atas laporannya.',
            'date_time_response' => now(),
        ]);

        // Assert report is updated (make sure you handle this in controller or model event!)
        $this->assertDatabaseHas('responses', [
            'report_id' => $report->report_id,
        ]);
    }
}
