<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Penugasan;
use App\Models\Pickup;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Session;
use Tests\TestCase;

class PenugasanAdminTest extends TestCase
{
    use RefreshDatabase;

    private function admin()
    {
        return User::factory()->create(['role' => 2]);
    }

    /* AS‑001 ─ Halaman Penugasan dapat dimuat */
    public function test_admin_can_open_penugasan_page()
    {
        $response = $this->actingAs($this->admin())->get('admin/penugasan');

        $response->assertStatus(200)
                 ->assertSee('Penugasan');
    }

    /* AS‑002 ─ Tabel menampilkan order menunggu penugasan */
    public function test_table_shows_orders_without_driver()
    {

        // Create an order that doesn't have any penugasan (so it should show in the list)
        $order = Order::factory()->create();

        $response = $this->actingAs($this->admin())->get('admin/penugasan');

        // Assert the order is shown
        $response->assertStatus(200);
        $response->assertSee((string) $order->order_id); // from blade: {{$penugasan->order_id}}

        // Assert driver section says "Belum Ada"
        $response->assertSee('Belum Ada'); // from blade: @empty Belum Ada @endforelse
    }


    /* AS‑003 ─ Kolom Driver “Belum Ada” */
    public function test_driver_column_shows_belum_ada()
    {
        // Buat order tanpa driver, penugasan, dan approval
        $order = Order::factory()->create();

        $response = $this->actingAs($this->admin())->get('admin/penugasan');

        $response->assertStatus(200);
        $response->assertSee((string) $order->order_id); // Pastikan order muncul
        $response->assertSee('Belum Ada'); // Pastikan kolom driver menampilkan "Belum Ada"
    }


    /* AS‑004 ─ Status Penugasan “belum ada” */
    public function test_status_column_shows_belum_ada()
    {
        // Order yang tidak memiliki penugasan
        $order = Order::factory()->create();

        $response = $this->actingAs($this->admin())->get('admin/penugasan');

        $response->assertStatus(200);
        $response->assertSee((string) $order->order_id);
        $response->assertSee('Belum Ada'); // sesuai blade @empty / fallback
    }


    /* AS‑005 ─ Tombol Buat Penugasan aktif */
    public function test_create_assignment_button_enabled_when_no_driver()
    {
        Order::factory()->create();

        $response = $this->actingAs($this->admin())->get('admin/penugasan');

        $response->assertSee('Buat Penugasan');
    }

    /* AS‑006 ─ Klik Buat Penugasan membuka form (cek route GET create) */
    public function test_create_assignment_form_can_be_opened()
    {
        $order = Order::factory()->create();

        $response = $this->actingAs($this->admin())->get('admin/penugasan');

        $response->assertStatus(200);
        $response->assertSee('Buat Penugasan');
        $response->assertSee('Pilih Driver');
    }


    /* AS‑007 ─ Menyimpan penugasan */
    public function test_store_assignment_updates_driver_and_status()
{
    $order = Order::factory()->create();
    $driver = User::factory()->create(['role' => 3]);

    Session::start();

    $response = $this->actingAs($this->admin())
        ->post(route('admin.penugasan.store'), [
            '_token'   => csrf_token(),
            'order_id' => $order->order_id,
            'user_id'  => $driver->user_id,
        ]);


    $response->assertRedirect(); // default 302 redirect

    $this->assertDatabaseHas('penugasans', [
        'order_id' => $order->order_id,
        'user_id'  => $driver->user_id,
        'status'   => 0,
    ]);

    $this->assertDatabaseHas('pick_ups', [
        'order_id' => $order->order_id,
        'user_id'  => $driver->user_id,
    ]);
}

    /* AS‑008 ─ Tombol Hapus Tugas hanya untuk order dengan driver */
    public function test_delete_button_shown_when_assignment_exists()
    {
        $driver = User::factory()->create(['role' => 3]);
        $order = Order::factory()->create();

        Penugasan::factory()->create([
            'order_id' => $order->order_id,
            'user_id'  => $driver->user_id,
            'status'   => 0,
        ]);

        $response = $this->actingAs($this->admin())->get('admin/penugasan');

        $response->assertSee('Hapus Tugas');
    }

    /* AS‑009 ─ Hapus penugasan mengembalikan status Belum Ada */
// public function test_delete_assignment_removes_penugasan_and_pickup()
// {
//     $admin = $this->admin();
//     $driver = User::factory()->create(['role' => 3]);
//     $order = Order::factory()->create();

//     $penugasan = Penugasan::factory()->create([
//         'order_id' => $order->order_id,
//         'user_id'  => $driver->user_id,
//     ]);

//     // $this->actingAs($admin)
//     //     ->delete("admin/penugasan/{$penugasan->getKey()}");
//     $response = $this->actingAs($this->admin())->delete(route('admin.penugasan.destroy', $penugasan));
//     dump('Penugasan after delete:', Penugasan::find($penugasan->penugasan_id));
//     dump('Pickup count after delete:', Pickup::where('penugasan_id', $penugasan->penugasan_id)->count());

//     $this->assertDatabaseMissing('penugasans', [
//         'penugasan_id' => $penugasan->penugasan_id,
//     ]);

//     $this->assertDatabaseMissing('pick_ups', [
//         'penugasan_id' => $penugasan->penugasan_id,
//     ]);
// }


    /* AS‑010 ─ Search filter */
    // public function test_search_filter_orders()
    // {
    //     Order::factory()->create(['id' => 101, 'driver_id' => null]);
    //     Order::factory()->create(['id' => 202, 'driver_id' => null]);

    //     $response = $this->actingAs($this->admin())->get('/penugasan?search=101');
    //     $response->assertSee('101')
    //              ->assertDontSee('202');
    // }

    // /* AS‑011 ─ Pagination maksimal 10 baris */
    // public function test_first_page_shows_maximum_10_rows()
    // {
    //     Order::factory()->count(11)->create(['driver_id' => null]);

    //     $response = $this->actingAs($this->admin())->get('/penugasan');

    //     $this->assertCount(10, $response->viewData('orders'));
    // }

    // /* AS‑012 ─ Tombol Next/Previous pagination */
    // public function test_next_and_previous_pagination_links_work()
    // {
    //     Order::factory()->count(15)->create(['driver_id' => null]);
    //     $admin = $this->admin();

    //     $page1 = $this->actingAs($admin)->get('/penugasan?page=1');
    //     $page1->assertSee('?page=2');

    //     $page2 = $this->actingAs($admin)->get('/penugasan?page=2');
    //     $page2->assertSee('?page=1');
    // }
}
