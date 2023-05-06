<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    // public function test_example()
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }

    public function test_login()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    
    public function test_login_with_correct_credentials()
    {
        $response = $this->post('/login', [
            'email' => 'user@user.com',
            'password' => 'password'
        ]);

        $response->assertRedirect('/home');
    }


    public function test_login_with_incorrect_credentials()
    {
        $user = User::factory()->create();
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password'
        ]);

        $response->assertSessionHasErrors();
    }


    public function test_register()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertViewIs('auth.register');
    }


    public function test_register_with_correct_credentials()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'haha@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $response->assertStatus(200);
        $response->assertViewIs('google2fa.register');

    }


    public function test_register_with_incorrect_credentials()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $response->assertSessionHasErrors();

    }


    public function test_register_with_existing_user()
    {
        $user = User::factory()->create();
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $response->assertSessionHasErrors();
    }


}
