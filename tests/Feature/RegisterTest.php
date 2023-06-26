<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_register_page()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertViewIs('auth.register');
    }

    public function test_submit_register_form()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'haha@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $response->assertStatus(200);
    }

    public function test_submit_register_form_with_incorrect_confirm_password()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'hoho@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'wrong-password'
        ]);

        $response->assertSessionHasErrors();

    }
}
