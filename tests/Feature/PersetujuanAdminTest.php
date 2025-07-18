<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PersetujuanAdminTest extends TestCase
{
    use RefreshDatabase;

    /* helper */
    private function admin()
    {
        return User::factory()->create(['role' => 'admin']);
    }

    /* ----------------------------------------------------------------
       AP‑001  Halaman Persetujuan dapat dimuat
    ---------------------------------------------------------------- */
    public function test_admin_can_open_persetujuan_page()
    {
        $response = $this->actingAs($this->admin())->get('/persetujuan');

        $response->assertStatus(200)
                 ->assertSee('Daftar Transaksi')
                 ->assertSee('Transaksi Disetujui')
                 ->assertSee('Transaksi Ditolak')
                 ->assertSee('Penukaran Hari Ini');
    }

    /* ----------------------------------------------------------------
       AP‑002  Kartu Transaksi Disetujui menampilkan hitungan benar
    ---------------------------------------------------------------- */
    public function test_card_approved_count_is_correct()
    {
        Transaksi::factory()->count(3)->create(['status' => 'APPROVED']);
        Transaksi::factory()->count(2)->create(['status' => 'REJECTED']);

        $response = $this->actingAs($this->admin())->get('/persetujuan');

        $response->assertSee('Transaksi Disetujui')
                 ->assertSee('3');      // angka 3 di kartu
    }

    /* ----------------------------------------------------------------
       AP‑003  Kartu Transaksi Ditolak menampilkan hitungan benar
    ---------------------------------------------------------------- */
    public function test_card_rejected_count_is_correct()
    {
        Transaksi::factory()->count(2)->create(['status' => 'REJECTED']);

        $response = $this->actingAs($this->admin())->get('/persetujuan');

        $response->assertSee('Transaksi Ditolak')
                 ->assertSee('2');
    }

    /* ----------------------------------------------------------------
       AP‑004  Kartu Penukaran Hari Ini menghitung transaksi hari ini
    ---------------------------------------------------------------- */
    public function test_card_today_exchange_count()
    {
        // 2 transaksi hari ini
        Transaksi::factory()->count(2)->create(['created_at' => now()]);
        // 1 transaksi kemarin
        Transaksi::factory()->create(['created_at' => now()->subDay()]);

        $response = $this->actingAs($this->admin())->get('/persetujuan');

        $response->assertSee('Penukaran Hari Ini')
                 ->assertSee('2');
    }

    /* ----------------------------------------------------------------
       AP‑005  Tabel menampilkan daftar transaksi pending
    ---------------------------------------------------------------- */
    public function test_table_shows_pending_transactions()
    {
        $pending = Transaksi::factory()->create(['status' => 'PENDING', 'sampah' => 'Botol Plastik']);

        $response = $this->actingAs($this->admin())->get('/persetujuan');

        $response->assertSee($pending->id)
                 ->assertSee('PENDING')
                 ->assertSee('Botol Plastik');
    }

    /* ----------------------------------------------------------------
       AP‑006  Pesan “No data available” jika tidak ada pending
    ---------------------------------------------------------------- */
    public function test_no_data_message_when_no_pending()
    {
        // hanya approved & rejected
        Transaksi::factory()->create(['status' => 'APPROVED']);

        $response = $this->actingAs($this->admin())->get('/persetujuan');

        $response->assertSee('No data available in table');
    }

    /* ----------------------------------------------------------------
       AP‑007  Respon setujui (Approve)
    ---------------------------------------------------------------- */
    public function test_admin_can_approve_transaction()
    {
        $trx = Transaksi::factory()->create(['status' => 'PENDING']);

        $response = $this->actingAs($this->admin())
                         ->patch("/persetujuan/{$trx->id}", ['status' => 'APPROVED']);

        $response->assertRedirect('/persetujuan');
        $this->assertDatabaseHas('transaksis', [
            'id'     => $trx->id,
            'status' => 'APPROVED',
        ]);
    }

    /* ----------------------------------------------------------------
       AP‑008  Respon tolak (Reject)
    ---------------------------------------------------------------- */
    public function test_admin_can_reject_transaction()
    {
        $trx = Transaksi::factory()->create(['status' => 'PENDING']);

        $this->actingAs($this->admin())
             ->patch("/persetujuan/{$trx->id}", ['status' => 'REJECTED']);

        $this->assertDatabaseHas('transaksis', [
            'id'     => $trx->id,
            'status' => 'REJECTED',
        ]);
    }

    /* ----------------------------------------------------------------
       AP‑009  Respon pending (kembali / tetap pending)
    ---------------------------------------------------------------- */
    public function test_admin_can_keep_transaction_pending()
    {
        $trx = Transaksi::factory()->create(['status' => 'PENDING']);

        $this->actingAs($this->admin())
             ->patch("/persetujuan/{$trx->id}", ['status' => 'PENDING']);

        $this->assertDatabaseHas('transaksis', [
            'id'     => $trx->id,
            'status' => 'PENDING',
        ]);
    }

    /* ----------------------------------------------------------------
       AP‑010  Search filter
    ---------------------------------------------------------------- */
    public function test_search_filter_works()
    {
        Transaksi::factory()->create(['status' => 'PENDING', 'id' => 111]);
        Transaksi::factory()->create(['status' => 'PENDING', 'id' => 222]);

        $response = $this->actingAs($this->admin())
                         ->get('/persetujuan?search=111');

        $response->assertSee('111')
                 ->assertDontSee('222');
    }

    /* ----------------------------------------------------------------
       AP‑011  Pagination maksimal 10 baris
    ---------------------------------------------------------------- */
    public function test_first_page_shows_max_10_rows()
    {
        Transaksi::factory()->count(11)->create(['status' => 'PENDING']);

        $response = $this->actingAs($this->admin())->get('/persetujuan');

        $this->assertCount(10, $response->viewData('transaksi'));
    }

    /* ----------------------------------------------------------------
       AP‑012  Next / Previous pagination
    ---------------------------------------------------------------- */
    public function test_pagination_next_and_previous_links()
    {
        Transaksi::factory()->count(15)->create(['status' => 'PENDING']);
        $admin = $this->admin();

        $page1 = $this->actingAs($admin)->get('/persetujuan?page=1');
        $page1->assertSee('?page=2');

        $page2 = $this->actingAs($admin)->get('/persetujuan?page=2');
        $page2->assertSee('?page=1');
    }
}
