<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;
use App\Services\TodolistService;

class TodolistServiceTest extends TestCase
{
    private TodolistService $todolistService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->todolistService = $this->app->make(TodolistService::class);
    }

    public function testTodolistNotNull(): void
    {
        $this->assertNotNull($this->todolistService);
    }

    public function testSaveTodo(): void
    {
        $this->todolistService->saveTodo('1', 'Belajar Laravel');
        $todolist = Session::get('todolist');
        foreach ($todolist as $value) {
            $this->assertEquals(1, $value['id']);
            $this->assertEquals('Belajar Laravel', $value['todo']);
        }
    }

    public function testGetTodolistEmtpy(): void
    {
        $todolist = $this->todolistService->getTodolist();
        $this->assertEmpty($todolist);
    }

    public function testGetTodolistNotEmpty(): void
    {
        $this->todolistService->saveTodo('1', 'Belajar Laravel');
        $this->todolistService->saveTodo('2', 'Belajar PHP');
        $todolist = $this->todolistService->getTodolist();
        $this->assertNotEmpty($todolist);
        $this->assertCount(2, $todolist);
        $this->assertEquals('Belajar Laravel', $todolist[0]['todo']);
        $this->assertEquals('Belajar PHP', $todolist[1]['todo']);
    }

    public function testRemoveTodo(): void
    {
        $this->todolistService->saveTodo('1', 'Belajar Laravel');
        $this->todolistService->saveTodo('2', 'Belajar PHP');

        $this->todolistService->removeTodo('3');
        $todolist = $this->todolistService->getTodolist();
        $this->assertCount(2, $todolist);
        $this->assertEquals('Belajar Laravel', $todolist[0]['todo']);
        $this->assertEquals('Belajar PHP', $todolist[1]['todo']);


        $this->todolistService->removeTodo('1');
        $todolist = $this->todolistService->getTodolist();
        $this->assertCount(1, $todolist);
        $this->assertEquals('Belajar PHP', $todolist[1]['todo']);
    }
}
