<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodolistControllerTest extends TestCase
{
    public function testTodolist()
    {
        $this->withSession([
            "user" => "ridho",
            "todolist" => [
                [
                    "id" => "1",
                    "todo" => "Ridho",
                ],

                [
                    "id" => "2",
                    "todo" => "andi",
                ],
            ]
        ])->get('/todolist')
            ->assertSeeText("1")
            ->assertSeeText("Ridho");
    }

    public function testAddTodoFailed()
    {
        $this->withSession([
            "user" => "ridho"
        ])->post("/todolist", [])
            ->assertSeeText("Todo is required");
    }

    public function testAddTodoSuccess()
    {
        $this->withSession([
            "user" => "ridho"
        ])->post("/todolist", [
            "todo" => "Ridho"
        ])->assertRedirect("/todolist");
    }

    public function testRemoveTodolist()
    {
        $this->withSession([
            "user" => "ridho",
            "todolist" => [
                [
                    "id" => "1",
                    "todo" => "Ridho",
                ],

                [
                    "id" => "2",
                    "todo" => "andi",
                ],
            ]
        ])->post('todolist/1/delete')
            ->assertRedirect('/todolist');
    }
}
