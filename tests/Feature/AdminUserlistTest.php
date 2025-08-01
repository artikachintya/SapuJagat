<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Trash;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminUserlistTest extends TestCase
{
    use RefreshDatabase;

    protected $admin, $driver, $trash, $order, $user;

    /** @test */
    public function test_user_list_page_displays_users_correctly()
    {
        $this->admin = User::create([
            'name' => 'Admin Sapu Jagat',
            'email' => 'driver@example.com',
            'password' => bcrypt('password'),
            'role' => 2,
        ]);

        $this->user = User::create([
            'name' => 'User Sapu Jagat',
            'email' => 'driver3@example.com',
            'password' => bcrypt('password'),
            'role' => 1,
            'status' => 1
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/user-lists');

        $response->assertStatus(200);
        $response->assertSee('User List');
        $response->assertSee("{$this->user->name}");

    }

    /** @test */
    public function test_block_button_changes_user_status()
    {
        $this->admin = User::create([
            'user_id' => 1,
            'name' => 'Admin Sapu Jagat',
            'email' => 'driver@example.com',
            'password' => bcrypt('password'),
            'role' => 2,
        ]);

        $this->user = User::create([
            'user_id' => 3,
            'name' => 'User Sapu Jagat',
            'email' => 'driver3@example.com',
            'password' => bcrypt('password'),
            'role' => 1,
            'status' => 1
        ]);

        $response = $this->actingAs($this->admin)->get("/admin/user-lists");

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'user_id' => $this->user->user_id,
            'status' => 1
        ]);
    }

    /** @test */
    public function test_log_button_displays_user_log()
    {
        $this->admin = User::create([
            'user_id' => 1,
            'name' => 'Admin Sapu Jagat',
            'email' => 'driver@example.com',
            'password' => bcrypt('password'),
            'role' => 2,
        ]);

        $this->user = User::create([
            'user_id' => 3,
            'name' => 'User Sapu Jagat',
            'email' => 'driver3@example.com',
            'password' => bcrypt('password'),
            'role' => 1,
        ]);

        $response = $this->actingAs($this->admin)->get("/admin/user-lists/1/logs");
        $response->assertSee("Tidak ada log tersedia untuk pengguna ini.");
        $response->assertStatus(200);
    }
}
