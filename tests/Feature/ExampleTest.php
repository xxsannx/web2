<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_the_application_returns_successful_response(): void
    {
        $response = $this->get('/');
        $response->assertStatus(302); // Redirect to login/register
    }
    
    public function test_authentication_redirect(): void
    {
        $response = $this->get('/home');
        $response->assertRedirect('/login');
    }
}