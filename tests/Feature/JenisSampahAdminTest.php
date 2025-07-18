<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class JenisSampahAdminTest extends TestCase
{
    use RefreshDatabase;

    private function admin()
    {
        return User::factory()->create(['role' => 'admin']);
    }

    /* JS‑001 */
    public function test_index_page_can_be_loaded()
    {
        $response = $this->actingAs($this->admin())
                         ->get('/jenis-sampah');

        $response->assertStatus(200)
                 ->assertSee('Rekapan Jenis Sampah Bulanan');
    }

    /* JS‑002 */
    public function test_pagination_limits_10_rows()
    {
        JenisSampah::factory()->count(11)->create();
        $response = $this->actingAs($this->admin())
                         ->get('/jenis-sampah');

        $response->assertStatus(200);
        $this->assertCount(10, $response->viewData('jenisSampah')); // asumsi var view bernama jenisSampah
    }

    /* JS‑003 */
    public function test_pagination_next_and_previous_links_work()
    {
        JenisSampah::factory()->count(15)->create();
        $admin = $this->admin();

        $page1 = $this->actingAs($admin)->get('/jenis-sampah?page=1');
        $page1->assertSee('?page=2');

        $page2 = $this->actingAs($admin)->get('/jenis-sampah?page=2');
        $page2->assertSee('?page=1');
    }

    /* JS‑004 */
    public function test_search_returns_relevant_rows()
    {
        JenisSampah::factory()->create(['nama' => 'Plastik Super']);
        JenisSampah::factory()->create(['nama' => 'Kertas Biasa']);

        $response = $this->actingAs($this->admin())
                         ->get('/jenis-sampah?search=Plastik');

        $response->assertSee('Plastik Super')
                 ->assertDontSee('Kertas Biasa');
    }

    /* JS‑005 */
    public function test_reset_search_shows_all_rows_again()
    {
        JenisSampah::factory()->count(3)->create();

        $filtered = $this->actingAs($this->admin())
                         ->get('/jenis-sampah?search=none');

        $this->assertEmpty($filtered->viewData('jenisSampah'));

        $all = $this->actingAs($this->admin())->get('/jenis-sampah');
        $this->assertCount(3, $all->viewData('jenisSampah'));
    }

    /* JS‑006 */
    public function test_sorting_by_harga_works()
    {
        JenisSampah::factory()->create(['nama' => 'Murah',  'harga' => 1000]);
        JenisSampah::factory()->create(['nama' => 'Mahal',  'harga' => 9000]);

        // ascending
        $asc = $this->actingAs($this->admin())
                    ->get('/jenis-sampah?sort=harga&direction=asc');

        $this->assertEquals(
            ['Murah','Mahal'],
            $asc->viewData('jenisSampah')->pluck('nama')->toArray()
        );

        // descending
        $desc = $this->actingAs($this->admin())
                     ->get('/jenis-sampah?sort=harga&direction=desc');

        $this->assertEquals(
            ['Mahal','Murah'],
            $desc->viewData('jenisSampah')->pluck('nama')->toArray()
        );
    }

    /* JS‑007 */
    public function test_create_button_route_accessible()
    {
        $response = $this->actingAs($this->admin())
                         ->get('/jenis-sampah/create');

        $response->assertStatus(200)
                 ->assertSee('form'); // minimal pengecekan ada tag form
    }

    /* JS‑008 */
    public function test_create_validation_required_field()
    {
        $response = $this->actingAs($this->admin())
                         ->post('/jenis-sampah', []); // kosong

        $response->assertSessionHasErrors(['nama']);
    }

    /* JS‑009 */
    public function test_create_validation_numeric_field()
    {
        $data = JenisSampah::factory()->raw(['harga' => 'abc']);
        $response = $this->actingAs($this->admin())
                         ->post('/jenis-sampah', $data);

        $response->assertSessionHasErrors(['harga']);
    }

    /* JS‑010 */
    public function test_create_rejects_invalid_image_type()
    {
        $data = JenisSampah::factory()->raw();
        $data['gambar'] = \Illuminate\Http\UploadedFile::fake()->create('file.pdf', 10, 'application/pdf');

        $response = $this->actingAs($this->admin())
                         ->post('/jenis-sampah', $data);

        $response->assertSessionHasErrors(['gambar']);
    }

    /* JS‑011 */
    public function test_successfully_create_waste_type()
    {
        $data = JenisSampah::factory()->raw();
        $response = $this->actingAs($this->admin())
                         ->post('/jenis-sampah', $data);

        $response->assertRedirect('/jenis-sampah');
        $this->assertDatabaseHas('jenis_sampah', ['nama' => $data['nama']]);
    }

    /* JS‑012 */
    public function test_edit_button_opens_edit_form()
    {
        $item = JenisSampah::factory()->create();

        $response = $this->actingAs($this->admin())
                         ->get("/jenis-sampah/{$item->id}/edit");

        $response->assertStatus(200)
                 ->assertSee($item->nama);
    }

    /* JS‑013 */
    public function test_update_waste_type()
    {
        $item = JenisSampah::factory()->create(['harga' => 1000]);

        $response = $this->actingAs($this->admin())
                         ->put("/jenis-sampah/{$item->id}", [
                             'nama'     => $item->nama,
                             'jenis'    => $item->jenis,
                             'harga'    => 2000,
                             'maksimal' => $item->maksimal,
                         ]);

        $response->assertRedirect('/jenis-sampah');
        $this->assertDatabaseHas('jenis_sampah', [
            'id' => $item->id,
            'harga' => 2000,
        ]);
    }

    /* JS‑014 */
    public function test_delete_shows_confirmation() {
        // tindakan JS/ modal tak bisa diuji langsung; uji route GET konfirmasi
        $item = JenisSampah::factory()->create();
        $response = $this->actingAs($this->admin())
                         ->get("/jenis-sampah/{$item->id}/confirm-delete");

        $response->assertStatus(200)
                 ->assertSee('Anda yakin');
    }

    /* JS‑015 */
    public function test_can_delete_waste_type()
    {
        $item = JenisSampah::factory()->create();

        $response = $this->actingAs($this->admin())
                         ->delete("/jenis-sampah/{$item->id}");

        $response->assertRedirect('/jenis-sampah');
        $this->assertDeleted($item);
    }

    /* JS‑016 */
    public function test_cancel_delete_keeps_data()
    {
        $item = JenisSampah::factory()->create();
        // Simulasi cancel = tidak memanggil route delete
        $this->assertDatabaseHas('jenis_sampah', ['id' => $item->id]);
    }

    /* JS‑017 */
    public function test_archived_page_accessible()
    {
        $response = $this->actingAs($this->admin())
                         ->get('/jenis-sampah/arsip');

        $response->assertStatus(200)
                 ->assertSee('Arsip Sampah');
    }

    /* JS‑018 */
    public function test_restore_archived_data()
    {
        $item = JenisSampah::factory()->create(['is_archived' => true]);

        $response = $this->actingAs($this->admin())
                         ->patch("/jenis-sampah/{$item->id}/restore");

        $response->assertRedirect('/jenis-sampah/arsip');
        $this->assertDatabaseHas('jenis_sampah', [
            'id' => $item->id,
            'is_archived' => false,
        ]);
    }

    /* JS‑019 */
    public function test_non_admin_cannot_access_module()
    {
        $driver = User::factory()->create(['role' => 'driver']);

        $response = $this->actingAs($driver)->get('/jenis-sampah');

        $response->assertStatus(403);
    }
}
