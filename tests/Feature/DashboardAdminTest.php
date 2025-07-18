<?php

namespace Tests\Feature;

use App\Models\Approval;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Trash;
use App\Models\User;
use Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class DashboardAdminTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_halaman_dashboard_dapat_diload()
    {
        $admin = User::create([
            'name' => 'Admin1',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 2,
        ]);

        $this->actingAs($admin);
        $this->withoutExceptionHandling();
        $response = $this->get('/admin');

        $response->assertStatus(200);
        $response->assertSeeText('Welcome, Admin1');
        $response->assertSee('Penukaran Hari Ini');
        $response->assertSee('Uang Keluar');
        $response->assertSee('Pesanan Diproses');
    }

    /** @test */
    public function kartu_penukaran_hari_ini_menampilkan_jumlah_transaksi()
    {
        try {
            $admin = User::create([
                'name' => 'Tester',
                'email' => 'tester@example.com',
                'password' => bcrypt('password'),
                'role' => 2,
            ]);
        
            $this->actingAs($admin);
            $this->withoutExceptionHandling();
            $user = User::factory()->create();
            Order::factory()->create([
                'user_id' => $user->getKey(),
            ]);
        
            $response = $this->get('/admin');
            $response->assertStatus(200);
            $response->assertSeeTextInOrder(['Total Transaksi', '5']);

        } catch (\Exception $e) {
            dd($e->getMessage(), $e->getTraceAsString());
        }
    }


    /** @test */
    public function test_kartu_uang_keluar_menampilkan_total_pengeluaran()
    {
        // Create admin manually (as in your working pattern)
        $admin = User::create([
            'name' => 'Admin1',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 2,
        ]);

        $this->actingAs($admin);
        $this->withoutExceptionHandling();

        // Create trash item
        $trash = Trash::factory()->create([
            'price_per_kg' => 100,
        ]);

        // Create user & order
        $user = User::factory()->create();
        $order = Order::factory()->create([
            'user_id' => $user->user_id,
            'status' => true,
        ]);

        // Create order detail
        OrderDetail::factory()->create([
            'order_id' => $order->order_id,
            'trash_id' => $trash->trash_id,
            'quantity' => 25,
        ]);

        // Create approval with status 1 (approved)
        Approval::factory()->create([
            'order_id' => $order->order_id,
            'user_id' => $admin->user_id,
            'approval_status' => 1,
        ]);

        $expectedTotal = 25 * 100; // quantity * price_per_kg

        // Hit the page
        $response = $this->get('/admin');
        $response->assertStatus(200);

        // Format match: <h5><small>RP</small>{{ number }}</h5>
        $response->assertSee('<h5 class="fw-bold mb-0"><small>RP</small>2500</h5>', false);
    }



    /** @test */
    public function tombol_lihat_histori_berfungsi()
    {
        $admin = User::factory()->create();
        $response = $this->actingAs($admin)->get('/admin');
        $response->assertSee('Lihat Semua Histori');
    }

    /** @test */
public function widget_tugas_persetujuan_menampilkan_order_belum_selesai()
{
    // Create admin user
    $admin = User::create([
        'name' => 'Admin1',
        'email' => 'admin@example.com',
        'password' => Hash::make('password'),
        'role' => 2,
    ]);

    $this->actingAs($admin);
    $this->withoutExceptionHandling();

    // Create a user for the order
    $user = User::factory()->create();

    // Create an order with no approval record
    $order = Order::factory()->create([
        'user_id' => $user->user_id,
        'status' => 1,
    ]);

    // Create trash and get the actual ID
    $trash = Trash::factory()->create(['price_per_kg' => 100]);

    // Use the actual trash ID
    OrderDetail::factory()->create([
        'order_id' => $order->order_id,
        'trash_id' => $trash->trash_id,
        'quantity' => 5,
    ]);

    $response = $this->get('/admin');

    $response->assertSee('Belum Selesai');
}



    /** @test */
    public function tombol_approve_deny_menampilkan_dialog()
    {
        $admin = User::factory()->create();

        $this->actingAs($admin);

        $response = $this->get('/admin');

        // Assert the text exists
        $response->assertSee('Approve/Deny');

        // Assert the link exists (raw HTML)
        $response->assertSee('/admin/persetujuan');
    }


    /** @test */
    public function navigasi_sidebar_ke_jenis_sampah_berfungsi()
    {
        $admin = User::factory()->create();
        $response = $this->actingAs($admin)->get('admin/jenis-sampah');
        $response->assertStatus(200);
        $response->assertSee('Jenis Sampah');
    }

    /** @test */
    public function admin_dapat_logout_dengan_sukses()
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->post('/logout');
        $response->assertRedirect('/login');
        $this->assertGuest();
    }

    /** @test */
    public function admin_dapat_mengakses_halaman_profile()
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->get('admin/profile');
        $response->assertStatus(200);
        $response->assertSee('Profile');
    }

    /** @test */
    public function test_admin_dapat_edit_profile()
    {
        // Fake storage
        Storage::fake('public');

        // Create user
        $admin = User::factory()->create([
            'name' => 'Old Name',
            'NIK' => '1234567890',
            'email' => 'old@example.com',
            'phone_num' => '08123456789',
            'password' => Hash::make('oldpassword'),
        ]);

        // New profile data
        $newData = [
            'name' => 'New Name',
            'NIK' => '1234567890', // NIK is not editable, but still sent
            'email' => 'new@example.com',
            'phone_num' => '08987654321',
            'password' => 'newpassword123',
            'profile_pic' => UploadedFile::fake()->create('profile.pdf', 100),
        ];

        // Send PUT request
        $response = $this->actingAs($admin)->post(route('admin.profile.save'), $newData);

        // Assert redirect
        $response->assertRedirect(route('admin.profile'));

        // Assert file was stored
        Storage::disk('public')->assertExists('profile_pictures/' . $newData['profile_pic']->hashName());

        // Refresh user
        $admin->refresh();

        // Assert updated values
        $this->assertEquals('New Name', $admin->name);
        $this->assertEquals('new@example.com', $admin->email);
        $this->assertEquals('08987654321', $admin->phone_num);
        $this->assertTrue(Hash::check('newpassword123', $admin->password));
        $this->assertStringContainsString('profile_pictures/', $admin->profile_pic);
    }
}
