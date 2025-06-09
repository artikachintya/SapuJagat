<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\User;
use Tests\TestCase;

class ExampleTest extends TestCase
{ 
    public function user_can_access_landing_page(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
}
