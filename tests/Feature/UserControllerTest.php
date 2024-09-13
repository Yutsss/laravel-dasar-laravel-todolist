<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function testLoginPage()
    {
        $this->get('/login')
            ->assertStatus(200)
            ->assertViewIs('user.login')
            ->assertViewHas('title', 'Login')
            ->assertSeeText('Login');
    }

    public function testAlreadyLogin()
    {
        $this->withSession(['user' => 'yuta'])
            ->get('/login')
            ->assertStatus(302)
            ->assertRedirect('/');
    }

    public function testDoLoginSuccess()
    {
        $this->post('/login', [
            'user' => 'yuta',
            'password' => 'yuta32154'
        ])
            ->assertStatus(302)
            ->assertRedirect('/');
    }

    public function testEmptyUsernameAndPassword()
    {
        $this->post('/login', [
            'user' => '',
            'password' => ''
        ])
            ->assertStatus(200)
            ->assertViewIs('user.login')
            ->assertViewHas('title', 'Login')
            ->assertSeeText('Username and password must be filled');
    }

    public function testEmptyUsername()
    {
        $this->post('/login', [
            'user' => '',
            'password' => 'yuta32154'
        ])
            ->assertStatus(200)
            ->assertViewIs('user.login')
            ->assertViewHas('title', 'Login')
            ->assertSeeText('Username and password must be filled');
    }

    public function testEmptyPassword()
    {
        $this->post('/login', [
            'user' => 'yuta',
            'password' => ''
        ])
            ->assertStatus(200)
            ->assertViewIs('user.login')
            ->assertViewHas('title', 'Login')
            ->assertSeeText('Username and password must be filled');
    }

    public function testDoLoginFailed()
    {
        $this->post('/login', [
            'user' => 'yuta',
            'password' => 'yuta321541'
        ])
            ->assertStatus(200)
            ->assertViewIs('user.login')
            ->assertViewHas('title', 'Login')
            ->assertSeeText('Username or password is incorrect');
    }

    public function testDoLogout()
    {
        $this->withSession(['user' => 'yuta'])
            ->post('/logout')
            ->assertStatus(302)
            ->assertRedirect('/login')
            ->assertSessionMissing('user');
    }

    public function testDoLogoutWithoutSession()
    {
        $this->post('/logout')
            ->assertStatus(302)
            ->assertRedirect('/login');
    }

}
