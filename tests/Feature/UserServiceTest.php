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


    public function testLoginSuccess()
    {
        self::assertTrue($this->userService->login('ridho', 'rahasia'));;
    }

    public function testLoginFalse()
    {
        self::assertFalse($this->userService->login('ridho', 'salah'));;
    }
}