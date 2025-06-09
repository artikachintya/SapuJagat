<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LandingTest extends TestCase
{
    /** @test */
    public function user_can_access_login_and_register_from_landing_page(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $this->get('/login')->assertStatus(200);
        $this->get('/register')->assertStatus(200);

        $this->get('/#fitur-section')->assertSee('Fitur');
        $this->get('/#testimoni-section')->assertSee('Testimoni');
        $this->get('/#faq-section')->assertSee('FAQ');
        $this->get('/#footer-section')->assertSee('Kontak');
    }
}
