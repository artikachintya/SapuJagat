<?php

namespace Tests\Feature;

use App\Models\Report;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Response;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class LaporanAdminTest extends TestCase
{
    use RefreshDatabase;

    private function admin()
    {
        return User::factory()->create(['role' => 2]);
    }

    /** @test */
    public function test_admin_can_open_laporan_page()
    {
        $response = $this->actingAs($this->admin())->get('admin/laporan');

        $response->assertStatus(200)
                 ->assertSee('Daftar Laporan dari Pengguna');
    }

    /** @test */
    public function test_table_shows_report_rows()
    {
        $report = Report::factory()->create([
            'report_message' => 'Sampah tidak diambil',
        ]);

        $response = $this->actingAs($this->admin())->get('admin/laporan');

        $response->assertSee((string) $report->report_id)
                ->assertSee('Sampah tidak diambil');
    }


    /** @test */
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

    /** @test */
    public function test_responded_at_is_dash_when_pending()
    {
        // Create a report with no response
        $report = Report::factory()->create([
            'report_message' => 'Belum direspon',
        ]);

        $response = $this->actingAs($this->admin())->get('admin/laporan');


        $response->assertSee((string) $report->report_id)
                ->assertSee('Belum direspon')
                ->assertSee('-');
    }

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

    public function test_admin_can_mark_report_as_responded()
    {
        $admin = $this->admin();

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
        // $response->assertSessionHas('success', 'Response send successfully');
        $response->assertSessionHas('success', 'Respon berhasil dikirim.');

        $this->assertDatabaseHas('responses', [
            'report_id' => $report->report_id,
            'user_id' => $admin->user_id,
            'response_message' => 'Terima kasih atas laporannya.',
            'date_time_response' => now(),
        ]);

        $this->assertDatabaseHas('responses', [
            'report_id' => $report->report_id,
        ]);
    }
}
