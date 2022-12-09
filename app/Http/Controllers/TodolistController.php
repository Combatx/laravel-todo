<?php

namespace App\Http\Controllers;

use App\Services\TodolistService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TodolistController extends Controller
{

    private TodolistService $todolistService;

    public function __construct(TodoListService $todolist)
    {
        $this->todolistService = $todolist;
    }

    public function todoList(Request $request)
    {
        $todolist = $this->todolistService->getTodolist();

        return response()->view("todolist.todolist", [
            "title" => "Todolist",
            "todoList" => $todolist
        ]);
    }

    public function addTodo(Request $request)
    {
        $todo = $request->input("todo");

        if (empty($todo)) {
            $todolist = $this->todolistService->getTodolist();
            return response()->view('todolist.todolist', [
                "title" => 'Todolist',
                'todoList' => $todolist,
                'error' => "Todo is required",
            ]);
        }

        $this->todolistService->saveTodo(uniqid(), $todo);

        return redirect()->action([TodolistController::class, 'todoList']);
    }

    public function removeTodo(Request $request, string $id): RedirectResponse
    {
        $this->todolistService->removeTodo($id);
        return redirect()->action([TodolistController::class, 'todoList']);
    }
}
