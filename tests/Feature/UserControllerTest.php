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
            ->assertSeeText("Login");
    }

    public function testLoginPageForMember()
    {
        $this->withSession([
            "user" =>  "ridho"
        ])->get('login')
            ->assertRedirect('/');
    }

    public function testLoginSuccess()
    {
        $this->post('/login', [
            "user" => "ridho",
            "password" => "rahasia"
        ])->assertRedirect('/')
            ->assertSessionHas("user", "ridho");
    }

    public function testLoginForUserAlreadyLogin()
    {
        $this->withSession([
            "user" =>  "ridho"
        ])->post('/login', [
            "user" => "ridho",
            "password" => "rahasia"
        ])->assertRedirect('/');
    }

    public function testLoginValidateError()
    {
        $this->post('/login', [])
            ->assertSeeText("User or password is required");
    }

    public function testLoginFailed()
    {
        $this->post('login', [
            'user' => 'wrong',
            'password' => 'wrong'
        ])->assertSeeText('User or password is wrong');
    }

    public function testLogout()
    {
        $this->withSession([
            "user" => "ridho"
        ])->post('/logout')
            ->assertSessionMissing("user");
    }

    public function testGuest()
    {
        $this->post('/logout')
            ->assertRedirect('/');
    }
}
