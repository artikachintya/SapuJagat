<?php

namespace Tests\Feature;

use App\Models\Trash;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class JenisSampahAdminTest extends TestCase
{
    use RefreshDatabase;

    private function admin()
    {
        return User::factory()->create(['role' => 2]);
    }

    /** @test */
    public function test_index_page_can_be_loaded()
    {
        $response = $this->actingAs($this->admin())
                        ->get('admin/jenis-sampah');

        $response->assertStatus(200)
                ->assertSee('Rekapan Jenis Sampah Bulanan');
    }

    /* JS‑002 */
    // public function test_pagination_limits_10_rows()
    // {
    //     Trash::factory()->count(11)->create();
    //     $response = $this->actingAs($this->admin())
    //                      ->get('admin/jenis-sampah');

    //     $response->assertStatus(200);
    //     $response->assertSee('Showing 1 to 10 of 10 entries');
    // }

    /* JS‑003 */
    // public function test_pagination_next_and_previous_links_work()
    // {
    //     JenisSampah::factory()->count(15)->create();
    //     $admin = $this->admin();

    //     $page1 = $this->actingAs($admin)->get('/jenis-sampah?page=1');
    //     $page1->assertSee('?page=2');

    //     $page2 = $this->actingAs($admin)->get('/jenis-sampah?page=2');
    //     $page2->assertSee('?page=1');
    // }

    // /* JS‑004 */
    // public function test_search_returns_relevant_rows()
    // {
    //     JenisSampah::factory()->create(['nama' => 'Plastik Super']);
    //     JenisSampah::factory()->create(['nama' => 'Kertas Biasa']);

    //     $response = $this->actingAs($this->admin())
    //                      ->get('/jenis-sampah?search=Plastik');

    //     $response->assertSee('Plastik Super')
    //              ->assertDontSee('Kertas Biasa');
    // }

    // /* JS‑005 */
    // public function test_reset_search_shows_all_rows_again()
    // {
    //     JenisSampah::factory()->count(3)->create();

    //     $filtered = $this->actingAs($this->admin())
    //                      ->get('/jenis-sampah?search=none');

    //     $this->assertEmpty($filtered->viewData('jenisSampah'));

    //     $all = $this->actingAs($this->admin())->get('/jenis-sampah');
    //     $this->assertCount(3, $all->viewData('jenisSampah'));
    // }

    // /* JS‑006 */
    // public function test_sorting_by_harga_works()
    // {
    //     JenisSampah::factory()->create(['nama' => 'Murah',  'harga' => 1000]);
    //     JenisSampah::factory()->create(['nama' => 'Mahal',  'harga' => 9000]);

    //     // ascending
    //     $asc = $this->actingAs($this->admin())
    //                 ->get('/jenis-sampah?sort=harga&direction=asc');

    //     $this->assertEquals(
    //         ['Murah','Mahal'],
    //         $asc->viewData('jenisSampah')->pluck('nama')->toArray()
    //     );

    //     // descending
    //     $desc = $this->actingAs($this->admin())
    //                  ->get('/jenis-sampah?sort=harga&direction=desc');

    //     $this->assertEquals(
    //         ['Mahal','Murah'],
    //         $desc->viewData('jenisSampah')->pluck('nama')->toArray()
    //     );
    // }

    /* JS‑007 */
    public function test_create_button_route_accessible()
    {
        $response = $this->actingAs($this->admin())
                     ->get('/admin/jenis-sampah');

        $response->assertStatus(200);

        // Test the create button text and modal trigger
        $response->assertSee('Buat Sampah', false);
        $response->assertSee('data-bs-toggle="modal"', false);
        $response->assertSee('data-bs-target="#createTrashModal"', false);
    }



    /* JS‑008 */
    public function test_create_validation_required_fields()
    {
        $response = $this->actingAs($this->admin())
                        ->post('admin/jenis-sampah', []); // intentionally empty

        $response->assertSessionHasErrors([
            'name',
            'type',
            'price_per_kg',
        ]);
    }

    /* JS‑009 */
    public function test_create_validation_numeric_field()
    {
        $data = Trash::factory()->raw(['price_per_kg' => 'abc']); // string instead of numeric

        $response = $this->actingAs($this->admin())
                        ->post('/admin/jenis-sampah', $data); // use full route path

        $response->assertSessionHasErrors(['price_per_kg']);
    }


    /* JS‑010 */
    public function test_create_rejects_invalid_image_type()
    {
        $data = Trash::factory()->raw();
        $data['photos'] = \Illuminate\Http\UploadedFile::fake()->create('file.pdf', 10, 'application/pdf');

        $response = $this->actingAs($this->admin())
                        ->post('/admin/jenis-sampah', $data); // use the full route if needed

        $response->assertSessionHasErrors(['photos']);
    }

    public function test_successfully_create_waste_type()
    {
        $data = Trash::factory()->raw();
        
        // Fake a .jpg file without using GD
        $data['photos'] = UploadedFile::fake()->create('dummy.jpg', 100, 'image/jpeg');

        $response = $this->actingAs($this->admin())
                        ->post('/admin/jenis-sampah', $data);

        $response->assertRedirect();

        $this->assertDatabaseHas('trashes', ['name' => $data['name']]);
    }

    /* JS‑012 */
    public function test_edit_button_contains_correct_data_attributes()
    {
        $trash = Trash::factory()->create();

        $response = $this->actingAs($this->admin())
                        ->get('/admin/jenis-sampah');

        $response->assertStatus(200);

        $response->assertSee('data-id="' . $trash->trash_id . '"', false);
        $response->assertSee('data-name="' . $trash->name . '"', false);
        $response->assertSee('data-type="' . $trash->type . '"', false);
        $response->assertSee('data-price_per_kg="' . $trash->price_per_kg . '"', false);
        $response->assertSee('data-max_weight="' . $trash->max_weight . '"', false);
        $response->assertSee('data-photo="' . $trash->photos . '"', false);
    }

    /* JS‑013 */
    public function test_update_waste_type()
    {
        $item = Trash::factory()->create(['price_per_kg' => 1000]);

        $response = $this->actingAs($this->admin())
                        ->put("/admin/jenis-sampah/{$item->trash_id}", [
                            'name'          => $item->name,
                            'type'          => $item->type,
                            'price_per_kg'  => 2000,
                            'max_weight'    => $item->max_weight,
                            // No need to send 'photos' if not testing upload
                        ]);

        $response->assertRedirect(); // or assertRedirect('/admin/jenis-sampah') if that's the intended redirect

        $this->assertDatabaseHas('trashes', [
            'trash_id'      => $item->trash_id,
            'price_per_kg'  => 2000,
        ]);
    }


    /* JS‑014 */
    public function test_delete_modal_is_visible_on_page()
    {
        $item = Trash::factory()->create();

        $response = $this->actingAs($this->admin())
                        ->get('admin/jenis-sampah');

        $response->assertStatus(200);
        $response->assertSee('HAPUS DATA');
        $response->assertSee('Apakah Anda yakin');
        $response->assertSee('deleteTrashModal');
    }


    /* JS‑015 */
    public function test_can_delete_waste_type()
    {
        $item = Trash::factory()->create();

        $response = $this->actingAs($this->admin())
                        ->from('/admin/jenis-sampah')
                        ->delete("/admin/jenis-sampah/{$item->trash_id}");

        // because destroy() returns back()
        $response->assertRedirect('/admin/jenis-sampah');

        $this->assertSoftDeleted('trashes', [
            'trash_id' => $item->trash_id,
        ]);
    }



    /* JS‑016 */
    public function test_delete_modal_is_visible_on_index_with_item_id()
    {
        $item = Trash::factory()->create();

        $response = $this->actingAs($this->admin())
                        ->get('/admin/jenis-sampah');

        $response->assertStatus(200);
        $response->assertSee('HAPUS DATA'); // modal title
        $response->assertSee('Apakah Anda yakin'); // modal text
        $response->assertSee((string) $item->id); // ID appears in the delete form or trigger button
    }


    /* JS‑017 */
    public function test_archived_page_accessible()
    {
        $response = $this->actingAs($this->admin())
                        ->get('admin/jenis-sampah-arsip');

        $response->assertStatus(200)
                ->assertSee('Sampah yang Dihapus');
    }


    /* JS‑018 */
    public function test_restore_archived_data()
    {
        $admin = $this->admin();

        $item = Trash::factory()->create();
        $item->delete(); // soft delete

        $response = $this->actingAs($admin)
                        ->post("/admin/jenis-sampah-restore/{$item->trash_id}");

        $response->assertRedirect('/admin/jenis-sampah');


        $this->assertDatabaseHas('trashes', [
            'trash_id' => $item->trash_id,
            'deleted_at' => null,
        ]);
    }

    /* JS‑019 */
    public function test_non_admin_cannot_access_module()
    {
        $driver = User::factory()->create(['role' => 3]);

        $response = $this->actingAs($driver)->get('/admin/jenis-sampah');

        $response->assertStatus(403);
    }

}
