<?php

namespace App\Http\Controllers;

use App\Services\TodolistService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class TodolistController extends Controller
{
    private TodolistService $todolistService;

    /**
     * @param TodolistService $todolistService
     */
    public function __construct(TodolistService $todolistService)
    {
        $this->todolistService = $todolistService;
    }

    public function todoList(Request $request): Response
    {
        return response()
            ->view('todolist.todolist', [
                'title' => 'Todolist',
                'todolist' => $this->todolistService->getTodolist()
            ]);
    }

    public function addTodo(Request $request): Response|RedirectResponse
    {
        $todo = $request->input('todo');

        if (empty($todo)) {
            return response()
                ->view('todolist.todolist', [
                    'title' => 'Todolist',
                    'todolist' => $this->todolistService->getTodolist(),
                    'error' => 'Todo must be filled'
                ]);
        }

        $this->todolistService->saveTodo(
            uniqid(),
            $todo
        );

        return redirect()->Action([TodolistController::class, 'todoList']);

    }

    public function removeTodo(Request $request, string $id): Response|RedirectResponse
    {
        $this->todolistService->removeTodo($id);

        return redirect()->Action([TodolistController::class, 'todoList']);
    }
}
