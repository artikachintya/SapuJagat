<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PenugasanAdminTest extends TestCase
{
    use RefreshDatabase;

    private function admin()
    {
        return User::factory()->create(['role' => 'admin']);
    }

    /* AS‑001 ─ Halaman Penugasan dapat dimuat */
    public function test_admin_can_open_penugasan_page()
    {
        $response = $this->actingAs($this->admin())->get('/penugasan');

        $response->assertStatus(200)
                 ->assertSee('Penugasan');
    }

    /* AS‑002 ─ Tabel menampilkan order menunggu penugasan */
    public function test_table_shows_orders_without_driver()
    {
        $order = Order::factory()->create(['driver_id' => null, 'assignment_status' => 'BELUM_ADA']);

        $response = $this->actingAs($this->admin())->get('/penugasan');

        $response->assertSee($order->id)
                 ->assertSee('Belum Ada');
    }

    /* AS‑003 ─ Kolom Driver “Belum Ada” */
    public function test_driver_column_shows_belum_ada()
    {
        $order = Order::factory()->create(['driver_id' => null]);

        $response = $this->actingAs($this->admin())->get('/penugasan');

        $response->assertSee('Belum Ada');
    }

    /* AS‑004 ─ Status Penugasan “belum ada” */
    public function test_status_column_shows_belum_ada()
    {
        $order = Order::factory()->create(['assignment_status' => 'BELUM_ADA']);

        $response = $this->actingAs($this->admin())->get('/penugasan');

        $response->assertSee('belum ada');
    }

    /* AS‑005 ─ Tombol Buat Penugasan aktif */
    public function test_create_assignment_button_enabled_when_no_driver()
    {
        Order::factory()->create(['driver_id' => null]);

        $response = $this->actingAs($this->admin())->get('/penugasan');

        $response->assertSee('Buat Penugasan');
    }

    /* AS‑006 ─ Klik Buat Penugasan membuka form (cek route GET create) */
    public function test_create_assignment_form_can_be_opened()
    {
        $order = Order::factory()->create(['driver_id' => null]);

        $response = $this->actingAs($this->admin())->get("/penugasan/{$order->id}/create");

        $response->assertStatus(200)
                 ->assertSee('Pilih Driver');
    }

    /* AS‑007 ─ Menyimpan penugasan */
    public function test_store_assignment_updates_driver_and_status()
    {
        $order  = Order::factory()->create(['driver_id' => null, 'assignment_status' => 'BELUM_ADA']);
        $driver = Driver::factory()->create();

        $this->actingAs($this->admin())
             ->post("/penugasan/{$order->id}", ['driver_id' => $driver->id]);

        $this->assertDatabaseHas('orders', [
            'id'                 => $order->id,
            'driver_id'          => $driver->id,
            'assignment_status'  => 'BELUM_SELESAI',
        ]);
    }

    /* AS‑008 ─ Tombol Hapus Tugas hanya untuk order dengan driver */
    public function test_delete_button_shown_when_assignment_exists()
    {
        $driver = Driver::factory()->create();
        Order::factory()->create([
            'driver_id'         => $driver->id,
            'assignment_status' => 'BELUM_SELESAI',
        ]);

        $response = $this->actingAs($this->admin())->get('/penugasan');

        $response->assertSee('Hapus Tugas');
    }

    /* AS‑009 ─ Hapus penugasan mengembalikan status Belum Ada */
    public function test_delete_assignment_resets_driver_and_status()
    {
        $driver = Driver::factory()->create();
        $order  = Order::factory()->create([
            'driver_id'         => $driver->id,
            'assignment_status' => 'BELUM_SELESAI',
        ]);

        $this->actingAs($this->admin())
             ->delete("/penugasan/{$order->id}");

        $this->assertDatabaseHas('orders', [
            'id'                 => $order->id,
            'driver_id'          => null,
            'assignment_status'  => 'BELUM_ADA',
        ]);
    }

    /* AS‑010 ─ Search filter */
    public function test_search_filter_orders()
    {
        Order::factory()->create(['id' => 101, 'driver_id' => null]);
        Order::factory()->create(['id' => 202, 'driver_id' => null]);

        $response = $this->actingAs($this->admin())->get('/penugasan?search=101');
        $response->assertSee('101')
                 ->assertDontSee('202');
    }

    /* AS‑011 ─ Pagination maksimal 10 baris */
    public function test_first_page_shows_maximum_10_rows()
    {
        Order::factory()->count(11)->create(['driver_id' => null]);

        $response = $this->actingAs($this->admin())->get('/penugasan');

        $this->assertCount(10, $response->viewData('orders'));
    }

    /* AS‑012 ─ Tombol Next/Previous pagination */
    public function test_next_and_previous_pagination_links_work()
    {
        Order::factory()->count(15)->create(['driver_id' => null]);
        $admin = $this->admin();

        $page1 = $this->actingAs($admin)->get('/penugasan?page=1');
        $page1->assertSee('?page=2');

        $page2 = $this->actingAs($admin)->get('/penugasan?page=2');
        $page2->assertSee('?page=1');
    }
}
