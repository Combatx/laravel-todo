<?php

namespace Tests\Feature;

use App\Services\TodolistService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;

class TodoListServiceTest extends TestCase
{
    private TodolistService $todolistService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->todolistService = $this->app->make(TodolistService::class);
    }

    public function testTodolistNotNull()
    {
        self::assertNotNull($this->todolistService);
    }

    public function testSaveTodo()
    {
        $this->todolistService->saveTodo("1", "Ridho");

        $todolist = Session::get("todolist");

        foreach ($todolist as $value) {
            self::assertEquals("1", $value['id']);
            self::assertEquals("Ridho", $value['todo']);
        }
    }

    public function testGetTodoListEmpty()
    {
        self::assertEquals([], $this->todolistService->getTodolist());
    }

    public function testGetTodoListNotEmpty()
    {
        $excepted = [
            [
                "id" => "1",
                "todo" => "Ridho"
            ],
            [
                "id" => "2",
                "todo" => "Aja"
            ],
        ];

        $this->todolistService->saveTodo("1", "Ridho");
        $this->todolistService->saveTodo("2", "Aja");

        self::assertEquals($excepted, $this->todolistService->getTodolist());
    }

    public function testRemoveTodo()
    {
        $this->todolistService->saveTodo("1", "Ridho");
        $this->todolistService->saveTodo("2", "Aja");

        self::assertEquals(2, sizeof($this->todolistService->getTodolist()));

        $this->todolistService->removeTodo("3");
        self::assertEquals(2, sizeof($this->todolistService->getTodolist()));


        $this->todolistService->removeTodo("1");
        self::assertEquals(1, sizeof($this->todolistService->getTodolist()));

        $this->todolistService->removeTodo("2");
        self::assertEquals(0, sizeof($this->todolistService->getTodolist()));
    }
}
