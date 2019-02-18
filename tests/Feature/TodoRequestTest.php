<?php

namespace Tests\Feature;

use App\Main\Todo\Repositories\TodoRepository;
use App\Main\Todo\Todo;
use function dd;
use Illuminate\Support\Collection;
use const SORT_REGULAR;
use Tests\TestCase;
use function factory;
use function route;
use function var_dump;

/**
 * Created by PhpStorm.
 * User: AndersonAndradede
 * Date: 18/02/2019
 * Time: 00:12
 */
class TodoRequestTest extends TestCase {


    /** @test */
    public function inserir_um_novo_todo() {

        $dados = [
            "tarefa" => $this->faker->words(3, true), "concluido" => $this->faker->boolean()
        ];

        $this->post(route('todo.store'), $dados)->assertStatus(201)->assertJson($this->arrayResponse($dados));

    }

    /** @test */
    public function exibir_um_todo_existente() {

        $item = factory(Todo::class)->create();

        $this->get(route('todo.show', $item->id))->assertStatus(200)->assertJson($this->arrayResponse($item->toArray()));
    }


    /** @test */
    public function alterar_um_todo_existente() {

        $dados = [
            "tarefa" => $this->faker->words(3, true), "concluido" => $this->faker->boolean()
        ];

        $this->put(route('todo.update', $this->todo->id), $dados)->assertStatus(200)->assertJson($this->arrayResponse($dados));
    }


    /** @test */
    public function remover_um_todo_existente() {

        $id = $this->todo->id;

        $this->delete(route('todo.destroy', $this->todo->id))->assertStatus(204);

        $this->get(route('todo.show', $id))->assertStatus(500);
    }


    /** @test */
    public function listar_todos_os_todos() {

        /** @var Collection $todos */
        factory(Todo::class, 49)->create();

        $this->get(route('todo.index'))->getContent();

        $repo = new TodoRepository(new Todo);
        $todos = $repo->listTodos();

        $this->get(route('todo.index'))->assertStatus(200)->assertJson([
                "data" => $todos->toArray()
            ])
        ;

    }
}
