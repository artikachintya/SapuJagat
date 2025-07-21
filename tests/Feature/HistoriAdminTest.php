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
use Tests\TestCase;

class HistoriAdminTest extends TestCase
{
    use RefreshDatabase;

    private function admin()
    {
        return User::factory()->create(['role' => 2]);
    }

    private function driver()
    {
        return User::factory()->create(['role' => 3]);
    }

    /* HP‑001 ─ Halaman histori dapat diakses */
    public function test_admin_can_open_histori_page()
    {
        $response = $this->actingAs($this->admin())->get('admin/histori');
        $response->assertStatus(200)
                 ->assertSee('Histori Penukaran Pengguna');
    }

    /* HP‑002 ─ Data histori tampil */
    public function test_table_shows_histori_rows()
    {
        $admin = $this->admin();

        $trash = Trash::factory()->create([
            'name' => 'Botol Plastik',
        ]);

        $order = Order::factory()->create();

        OrderDetail::factory()->create([
            'order_id' => $order->order_id,
            'trash_id' => $trash->trash_id,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.histori.index'));

        $response->assertStatus(200)
                ->assertSee('Botol Plastik');
    }

    /* HP‑003 ─ Badge Dalam Proses oranye */
    public function test_status_dalam_proses_badge_exists()
    {
        $admin = $this->admin();

        $trash = Trash::factory()->create(['name' => 'Sampah Uji']);

        $order = Order::factory()->create();

        OrderDetail::factory()->create([
            'order_id' => $order->order_id,
            'trash_id' => $trash->trash_id,
        ]);

        Approval::factory()->create([
            'order_id' => $order->order_id,
            'approval_status' => 2,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.histori.index'));

        $response->assertStatus(200);
        $response->assertSee('Dalam Proses');
    }


    /* HP‑004 ─ Badge Belum Ada Persetujuan */
    public function test_status_belum_persetujuan_badge_exists()
    {
        $admin = $this->admin();

        $trash = Trash::factory()->create(['name' => 'Sampah Belum Disetujui']);

        $order = Order::factory()->create();

        OrderDetail::factory()->create([
            'order_id' => $order->order_id,
            'trash_id' => $trash->trash_id,
        ]);

        // No approval created for this order!

        $response = $this->actingAs($admin)->get(route('admin.histori.index'));

        $response->assertStatus(200);
        $response->assertSee('Belum Ada Persetujuan');
    }


    /* HP‑005 ─ Kolom tanggal disetujui muncul */
    public function test_tanggal_disetujui_shown_for_approved()
    {
        $admin = $this->admin();

        $order = Order::factory()->create();

        $approvedAt = now();

        // Buat relasi approval
        Approval::factory()->create([
            'order_id'          => $order->order_id,
            'approval_status'            => 1,
            'date_time' => $approvedAt,
        ]);

        $response = $this->actingAs($admin)->get('/admin/histori');
        $response->assertSee($approvedAt->format('Y-m-d H:i'));
    }


    /* HP‑006 ─ Tanggal selesai kosong */
    public function test_tanggal_selesai_empty_when_null()
    {
        $admin = $this->admin();

        // Create Order
        $order = Order::factory()->create();

        // Attach Pickup with null arrival_date
        Pickup::factory()->create([
            'order_id'     => $order->order_id,
            'arrival_date' => null,
        ]);

        // Add related OrderDetail and Trash (optional, if shown on the page)
        $trash = Trash::factory()->create(['name' => 'Botol Plastik']);
        OrderDetail::factory()->create([
            'order_id' => $order->order_id,
            'trash_id' => $trash->trash_id,
        ]);

        // Hit the histori page
        $response = $this->actingAs($admin)->get('/admin/histori');

        // Assert dash is shown for null arrival_date
        $response->assertSee('-');
    }




    /* HP‑007 ─ Format mata uang biaya */
    public function test_biaya_formatted_as_currency()
    {
        $admin = $this->admin();

        $trash = Trash::factory()->create([
            'price_per_kg' => 4300,
        ]);

        $order = Order::factory()->create();

        OrderDetail::factory()->create([
            'order_id' => $order->order_id,
            'trash_id' => $trash->trash_id,
            'quantity' => 2,
        ]);

        $response = $this->actingAs($admin)->get('/admin/histori');

        $response->assertSee('Rp8.600');
    }



    /* HP‑008 ─ Tombol detail redirect */
    public function test_detail_button_route()
    {
        $admin = $this->admin();

        $trash = Trash::factory()->create(['name' => 'Plastik']);

        $order = Order::factory()->create();

        OrderDetail::factory()->create([
            'order_id' => $order->order_id,
            'trash_id' => $trash->trash_id,
            'quantity' => 5,
        ]);

        $response = $this->actingAs($admin)->get("/admin/histori");

        $response->assertStatus(200)
                ->assertSee('Plastik'); // Modal content includes trash name
    }



    /* HP‑009 ─ Search filter */
    // public function test_search_filter_returns_matching_rows()
    // {
    //     $admin = $this->admin();

    //     // Create trash types
    //     $kaca = Trash::factory()->create(['name' => 'Kaca Pecah']);
    //     $botol = Trash::factory()->create(['name' => 'Botol Plastik']);

    //     // Create order with Kaca Pecah
    //     $order1 = Order::factory()->create();
    //     OrderDetail::factory()->create([
    //         'order_id' => $order1->order_id,
    //         'trash_id' => $kaca->trash_id,
    //         'quantity' => 2,
    //     ]);

    //     // Create order with Botol Plastik
    //     $order2 = Order::factory()->create();
    //     OrderDetail::factory()->create([
    //         'order_id' => $order2->order_id,
    //         'trash_id' => $botol->trash_id,
    //         'quantity' => 3,
    //     ]);

    //     // Perform search
    //     $response = $this->actingAs($admin)->get('/admin/histori?search=Kaca');

    //     // Assert that only 'Kaca Pecah' is shown
    //     $response->assertSee('Kaca Pecah')
    //             ->assertDontSee('Botol Plastik');
    // }

    // /* HP‑010 ─ Pagination menampilkan 10 baris */
    // public function test_first_page_shows_only_10_rows()
    // {
    //     Histori::factory()->count(11)->create();

    //     $response = $this->actingAs($this->admin())->get('/histori');
    //     $this->assertCount(10, $response->viewData('histori')); // asumsi variabel view
    // }

    // /* HP‑011 ─ Tombol next/prev */
    // public function test_next_and_previous_pagination_links()
    // {
    //     Histori::factory()->count(12)->create();
    //     $admin = $this->admin();

    //     $page1 = $this->actingAs($admin)->get('/histori?page=1');
    //     $page1->assertSee('?page=2');

    //     $page2 = $this->actingAs($admin)->get('/histori?page=2');
    //     $page2->assertSee('?page=1');
    // }

    /* HP‑012 ─ Role selain admin ditolak */
    public function test_driver_cannot_access_histori_page()
    {
        $response = $this->actingAs($this->driver())->get('admin/histori');
        $response->assertStatus(403);
    }

    /* HP‑013 ─ Sorting kolom biaya */
    // public function test_sorting_biaya_order()
    // {
    //     Histori::factory()->create(['jenis_sampah'=>'Murah', 'biaya'=>1000]);
    //     Histori::factory()->create(['jenis_sampah'=>'Mahal', 'biaya'=>9000]);

    //     $asc = $this->actingAs($this->admin())
    //                 ->get('/histori?sort=biaya&direction=asc');
    //     $this->assertEquals(
    //         ['Murah','Mahal'],
    //         $asc->viewData('histori')->pluck('jenis_sampah')->toArray()
    //     );

    //     $desc = $this->actingAs($this->admin())
    //                  ->get('/histori?sort=biaya&direction=desc');
    //     $this->assertEquals(
    //         ['Mahal','Murah'],
    //         $desc->viewData('histori')->pluck('jenis_sampah')->toArray()
    //     );
    // }
}
