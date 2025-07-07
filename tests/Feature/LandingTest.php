<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LandingTest extends TestCase
{
    /** @test */
    public function user_admin_driver_can_access_login_and_register_from_landing_page(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $this->get('/login')->assertStatus(200);
        $this->get('/register')->assertStatus(200);

        $this->get('/#fitur-section')->assertStatus(200)->assertSee('Fitur');
        $this->get('/#testimoni-section')->assertStatus(200)->assertSee('Testimoni');
        $this->get('/#faq-section')->assertStatus(200)->assertSee('FAQ');
        $this->get('/#footer-section')->assertStatus(200)->assertSee('Kontak');
    }
}
