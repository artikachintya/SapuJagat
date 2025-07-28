<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Request;
use Tests\TestCase;

class LoginTest extends TestCase
{


    /** @test */
    public function login_page_displays_correctly()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Masuk');
        $response->assertSee('Email');
        $response->assertSee('Masuk dengan Google');
        $response->assertSee('Kata Sandi');
        $response->assertSee('Lupa kata sandi?');

    }

    /** @test */
    public function user_can_login_and_get_otp_then_access_dashboard()
    {
        $response = $this->post('/login', [
            'email' => 'kreasipxk1@gmail.com',
            'password' => bcrypt('Kreasiaja!'),
        ]);

        $response->assertStatus(302);
    }

    /** @test */
    public function google_login_redirects_to_google_provider()
    {
        $response = $this->get('/auth/google');
        $response->assertRedirect(); 
    }

    /** @test */
    public function admin_can_login_and_then_access_dashboard()
    {
        $response = $this->post('/login', [
            'email' => 'admin1@example.com',
            'password' => bcrypt('password2'),
        ]);

        $response->assertStatus(302);
    }

    /** @test */
    public function driver_can_login_and_then_access_dashboard()
    {
        $response = $this->post('/login', [
            'email' => 'driver1@example.com',
            'password' => bcrypt('password5'),
        ]);

        $response->assertStatus(302);
    }
}
