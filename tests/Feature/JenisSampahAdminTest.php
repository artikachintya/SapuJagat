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
    /** @test */
    public function test_create_button_route_accessible()
    {
        $response = $this->actingAs($this->admin())
                     ->get('/admin/jenis-sampah');

        $response->assertStatus(200);

        $response->assertSee('Buat Sampah', false);
        $response->assertSee('data-bs-toggle="modal"', false);
        $response->assertSee('data-bs-target="#createTrashModal"', false);
    }

    /** @test */
    public function test_create_validation_required_fields()
    {
        $response = $this->actingAs($this->admin())
                        ->post('admin/jenis-sampah', []);

        $response->assertSessionHasErrors([
            'name',
            'type',
            'price_per_kg',
        ]);
    }

    /** @test */
    public function test_create_validation_numeric_field()
    {
        $data = Trash::factory()->raw(['price_per_kg' => 'abc']);

        $response = $this->actingAs($this->admin())
                        ->post('/admin/jenis-sampah', $data);

        $response->assertSessionHasErrors(['price_per_kg']);
    }


    /** @test */
    public function test_create_rejects_invalid_image_type()
    {
        $data = Trash::factory()->raw();
        $data['photos'] = \Illuminate\Http\UploadedFile::fake()->create('file.pdf', 10, 'application/pdf');

        $response = $this->actingAs($this->admin())
                        ->post('/admin/jenis-sampah', $data);

        $response->assertSessionHasErrors(['photos']);
    }

    /** @test */
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

    /** @test */
    public function test_update_waste_type()
    {
        $item = Trash::factory()->create(['price_per_kg' => 1000]);

        $response = $this->actingAs($this->admin())
                        ->put("/admin/jenis-sampah/{$item->trash_id}", [
                            'name'          => $item->name,
                            'type'          => $item->type,
                            'price_per_kg'  => 1000,
                            'max_weight'    => $item->max_weight,
                        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('trashes', [
            'trash_id'      => $item->trash_id,
            'price_per_kg'  => 1000,
        ]);
    }


    /** @test */
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


    /** @test */
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



    /** @test */
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
