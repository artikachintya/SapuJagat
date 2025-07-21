<?php

namespace Tests\Feature;

use App\Models\Approval;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Pickup;
use App\Models\Trash;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Session;
use Tests\TestCase;

class PersetujuanAdminTest extends TestCase
{
    use RefreshDatabase;

    /* helper */
    private function admin()
    {
        return User::factory()->create(['role' => 2]);
    }

    /* ----------------------------------------------------------------
       AP‑001  Halaman Persetujuan dapat dimuat
    ---------------------------------------------------------------- */
    public function test_admin_can_open_persetujuan_page()
    {
        $response = $this->actingAs($this->admin())->get('admin/persetujuan');

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
        // Create 3 APPROVED orders
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

        // Create 2 REJECTED orders
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

        // Act as admin and get the response
        $response = $this->actingAs($this->admin())->get('admin/persetujuan');

        // Check that the HTML has the label and correct number
        $response->assertSeeInOrder([
            'Transaksi Disetujui',
            '3'
        ]);
    }

    /* ----------------------------------------------------------------
       AP‑003  Kartu Transaksi Ditolak menampilkan hitungan benar
    ---------------------------------------------------------------- */
    public function test_card_rejected_count_is_correct()
    {
        // Create 2 REJECTED orders with pickUps
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

        // Act as admin and hit the correct URL
        $response = $this->actingAs($this->admin())->get('/admin/persetujuan');

        // Assert "Transaksi Ditolak" and the count 2 appear in order
        $response->assertSeeInOrder([
            'Transaksi Ditolak',
            '2'
        ]);
    }

    /* ----------------------------------------------------------------
       AP‑004  Kartu Penukaran Hari Ini menghitung transaksi hari ini
    ---------------------------------------------------------------- */
    public function test_card_today_exchange_count()
    {
        // 2 transactions with today's request date and pick up
        for ($i = 0; $i < 2; $i++) {
            $order = Order::factory()->create([
                'date_time_request' => now(),
            ]);

            PickUp::factory()->create([
                'order_id' => $order->order_id,
            ]);
        }

        // 1 transaction with yesterday's date (should NOT be counted)
        $orderYesterday = Order::factory()->create([
            'date_time_request' => now()->subDay(),
        ]);

        PickUp::factory()->create([
            'order_id' => $orderYesterday->order_id,
        ]);

        // Access correct route
        $response = $this->actingAs($this->admin())->get('/admin/persetujuan');

        // Assert the card shows 2 for today's exchanges
        $response->assertSeeInOrder([
            'Penukaran Hari Ini',
            '2'
        ]);
    }


    /* ----------------------------------------------------------------
       AP‑005  Tabel menampilkan daftar transaksi pending
    ---------------------------------------------------------------- */
    public function test_table_shows_pending_transactions()
    {
        // Create trash
        $trash = Trash::factory()->create(['name' => 'Botol Plastik']);

        // Create the order
        $order = Order::factory()->create();

        // Create approval with status = 2 (Pending)
        Approval::factory()->create([
            'order_id' => $order->order_id,
            'approval_status' => 2,
        ]);

        // Create pickup to satisfy whereHas('pickUp')
        PickUp::factory()->create([
            'order_id' => $order->order_id,
        ]);

        // Attach trash via order detail
        OrderDetail::factory()->create([
            'order_id' => $order->order_id,
            'trash_id' => $trash->trash_id,
        ]);

        // Hit the correct route
        $response = $this->actingAs($this->admin())->get('/admin/persetujuan');

        // Assert the table row contains expected data
        $response->assertSee('Pending');
        $response->assertSee('Botol Plastik');
    }


    /* ----------------------------------------------------------------
       AP‑006  Pesan “No data available” jika tidak ada pending
    ---------------------------------------------------------------- */
    // public function test_no_data_message_when_no_pending()
    // {
    //     // hanya approved & rejected
    //     Transaksi::factory()->create(['status' => 'APPROVED']);

    //     $response = $this->actingAs($this->admin())->get('/persetujuan');

    //     $response->assertSee('No data available in table');
    // }

    /* ----------------------------------------------------------------
       AP‑007  Respon setujui (Approve)
    ---------------------------------------------------------------- */
    public function test_admin_can_approve_transaction()
    {
        Session::start();

        $order = Order::factory()->create();
        $user = User::factory()->create(['role' => 2]);

        $response = $this->withoutExceptionHandling()->actingAs($user)->post(route('admin.persetujuan.store'), [
            '_token'          => csrf_token(),
            'order_id'        => $order->order_id,
            'user_id'         => $user->user_id,  
            'approval_status' => 1,
            'notes'           => 'Disetujui oleh admin',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('approvals', [
            'order_id'        => $order->order_id,
            'user_id'         => $user->user_id,
            'approval_status' => 1,
            'notes'           => 'Disetujui oleh admin',
        ]);
    }

    /* ----------------------------------------------------------------
       AP‑008  Respon tolak (Reject)
    ---------------------------------------------------------------- */
    public function test_admin_can_reject_transaction()
    {
        Session::start();

        $order = Order::factory()->create();
        $user = User::factory()->create(['role' => 2]);

        $response = $this->withoutExceptionHandling()->actingAs($user)->post(route('admin.persetujuan.store'), [
            '_token'          => csrf_token(),
            'order_id'        => $order->order_id,
            'user_id'         => $user->user_id,  
            'approval_status' => 0,
            'notes'           => 'Ditolak oleh admin',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('approvals', [
            'order_id'        => $order->order_id,
            'user_id'         => $user->user_id,
            'approval_status' => 0,
            'notes'           => 'Ditolak oleh admin',
        ]);
    }


    /* ----------------------------------------------------------------
       AP‑009  Respon pending (kembali / tetap pending)
    ---------------------------------------------------------------- */
    public function test_admin_can_keep_transaction_pending()
    {
        Session::start();

        $order = Order::factory()->create();
        $user = User::factory()->create(['role' => 2]);

        $response = $this->withoutExceptionHandling()->actingAs($user)->post(route('admin.persetujuan.store'), [
            '_token'          => csrf_token(),
            'order_id'        => $order->order_id,
            'user_id'         => $user->user_id,  
            'approval_status' => 2,
            'notes'           => 'Dipending oleh admin',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('approvals', [
            'order_id'        => $order->order_id,
            'user_id'         => $user->user_id,
            'approval_status' => 2,
            'notes'           => 'Dipending oleh admin',
        ]);
    }

    /* ----------------------------------------------------------------
       AP‑010  Search filter
    ---------------------------------------------------------------- */
    // public function test_search_filter_works()
    // {
    //     Transaksi::factory()->create(['status' => 'PENDING', 'id' => 111]);
    //     Transaksi::factory()->create(['status' => 'PENDING', 'id' => 222]);

    //     $response = $this->actingAs($this->admin())
    //                      ->get('/persetujuan?search=111');

    //     $response->assertSee('111')
    //              ->assertDontSee('222');
    // }

    // /* ----------------------------------------------------------------
    //    AP‑011  Pagination maksimal 10 baris
    // ---------------------------------------------------------------- */
    // public function test_first_page_shows_max_10_rows()
    // {
    //     Transaksi::factory()->count(11)->create(['status' => 'PENDING']);

    //     $response = $this->actingAs($this->admin())->get('/persetujuan');

    //     $this->assertCount(10, $response->viewData('transaksi'));
    // }

    // /* ----------------------------------------------------------------
    //    AP‑012  Next / Previous pagination
    // ---------------------------------------------------------------- */
    // public function test_pagination_next_and_previous_links()
    // {
    //     Transaksi::factory()->count(15)->create(['status' => 'PENDING']);
    //     $admin = $this->admin();

    //     $page1 = $this->actingAs($admin)->get('/persetujuan?page=1');
    //     $page1->assertSee('?page=2');

    //     $page2 = $this->actingAs($admin)->get('/persetujuan?page=2');
    //     $page2->assertSee('?page=1');
    // }
}
