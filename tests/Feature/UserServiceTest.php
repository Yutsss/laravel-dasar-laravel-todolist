<?php

namespace Tests\Feature;

use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    private UserService $userService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userService = $this->app->make(UserService::class);
    }

    public function testSample(): void
    {
        $this->assertTrue(true);
    }

    public function testLoginSuccess(): void
    {
        $this->assertTrue($this->userService->login('yuta', 'yuta32154'));
        $this->assertTrue($this->userService->login('atuy', 'atuy32154'));
        $this->assertTrue($this->userService->login('yoet', 'yoet32154'));
    }

    public function testLoginUserNotFound(): void
    {
        $this->assertFalse($this->userService->login('yut', 'yuta32154'));
        $this->assertFalse($this->userService->login('utay', 'utay3215'));
        $this->assertFalse($this->userService->login('oet', 'oet3215'));
    }

    public function testLoginPasswordIncorrect(): void
    {
        $this->assertFalse($this->userService->login('yuta', 'yuta3215'));
        $this->assertFalse($this->userService->login('atuy', 'atuy3215'));
        $this->assertFalse($this->userService->login('yoet', 'yoet3215'));
    }
}
