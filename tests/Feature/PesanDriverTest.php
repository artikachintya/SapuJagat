<?php

namespace Tests\Feature;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PesanDriverTest extends TestCase
{

    use RefreshDatabase;
    protected $user, $driver, $user1, $user2, $chat;

    /** @test */
    public function driver_can_see_list_of_users_who_have_chatted()
    {
        $this->driver = User::create([
            'user_id' => 1,
            'name' => 'Jhon Doe',
            'email' => 'adminnn@example.com',
            'password' => bcrypt('password'),
            'role' => 3
        ]);

        $this->user = User::create([
            'user_id' => 2,
            'name' => 'Jhon Doe2',
            'email' => 'adminii@example.com',
            'password' => bcrypt('password'),
            'role' => 1
        ]);

        Chat::create([
            'chat_id' => 2,
            'driver_id' => 1,
            'user_id' => 2,
            'date_time_created' => now(),
        ]);

        Chat::create([
            'chat_id' => 2,
            'user_id' => 2,
            'driver_id' => 1,
            'date_time_created' => now(),
        ]);

        $this->actingAs($this->driver)
            ->get("/driver/chat")
            ->assertStatus(200)
            ->assertSee('Daftar Pesan Pengguna');
    }

    /** @test */
    public function driver_can_send_a_message_to_user()
    {
        $this->driver = User::create([
            'name' => 'Jhon Doe',
            'user_id' => '999',
            'email' => 'adminnn@example.com',
            'password' => bcrypt('password'),
            'role' => 3
        ]);

        $this->user = User::create([
            'name' => 'Jhon Doe',
            'user_id' => '9999',
            'email' => 'adminiii@example.com',
            'password' => bcrypt('password'),
            'role' => 1
        ]);

        $this->actingAs($this->driver)
            ->get('/driver/chat', [
                'user_id' => $this->user->id,
                'chat_detail' => 'Test kirim pesan',
            ])
            ->assertStatus(200)
            ->assertSessionHasNoErrors();
    }
}
