<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodolistControllerTest extends TestCase
{
    public function testTodoList(): void
    {
        $this->withSession([
            'user' => 'yuta',
            "todolist" => [
                [
                    "id" => 1,
                    "todo" => "Belajar Laravel"
                ],
                [
                    "id" => 2,
                    "todo" => "Belajar PHP"
                ]
            ]
        ])->get('/todolist')
            ->assertStatus(200)
            ->assertViewIs('todolist.todolist')
            ->assertViewHas('title', 'Todolist')
            ->assertViewHas('todolist')
            ->assertSeeText('Todolist')
            ->assertSeeText('Belajar Laravel')
            ->assertSeeText('Belajar PHP');

    }

    public function testAddTodoFailed()
    {
        $this->withSession([
            'user' => 'yuta'
        ])->post('/todolist', ['todo' => ''])
            ->assertStatus(200)
            ->assertViewIs('todolist.todolist')
            ->assertViewHas('title', 'Todolist')
            ->assertViewHas('todolist')
            ->assertViewHas('error', 'Todo must be filled');
    }

    public function testAddTodoSuccess()
    {
        $this->withSession([
            'user' => 'yuta'
        ])->post('/todolist', ['todo' => 'Belajar Laravel'])
            ->assertStatus(302)
            ->assertRedirect('/todolist');
    }

    public function testRemoveTodo()
    {
        $this->withSession([
            'user' => 'yuta',
            "todolist" => [
                [
                    "id" => 1,
                    "todo" => "Belajar Laravel"
                ],
                [
                    "id" => 2,
                    "todo" => "Belajar PHP"
                ]
            ]
        ])->post('/todolist/1/delete')
            ->assertStatus(302)
            ->assertRedirect('/todolist');
    }


}
