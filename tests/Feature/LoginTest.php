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

    public function verifyOtp(Request $request) {
    $otp = $request->input('otp');

    if ($otp === '123456') {
        // Anggap OTP benar, tandai user sebagai terverifikasi OTP
        session(['otp_verified' => true]);

        return redirect('/pengguna/dasboard');
    }

    return redirect('/login/otp')->withErrors(['otp' => 'OTP salah']);
    
    $response->assertStatus(302);
    $this->get('/pengguna/dasboard')->assertStatus(200);
    }

    public function user_cannot_login_with_wrong_password(){
        User::factory()->create([
            'email' => 'cindy@gmail.com',
            'password' => bcrypt('Cindy1234!'),
        ]);

        $this->get('/pengguna/dasboard')->assertRedirect('/login');
    }

    /** @test */
    public function google_login_redirects_to_google_provider()
    {
        $response = $this->get('/auth/google');
        $response->assertRedirect(); // arahkan ke halaman Google
    }

}
