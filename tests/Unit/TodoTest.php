<?php

namespace Tests\Unit;

use App\Main\Todo\Exceptions\CreateTodoInvalidArgumentException;
use App\Main\Todo\Exceptions\TodoNotFoundException;
use App\Main\Todo\Exceptions\UpdateTodoInvalidArgumentException;
use App\Main\Todo\Repositories\TodoRepository;
use App\Main\Todo\Todo;
use function factory;
use function json_encode;
use function str_repeat;
use Tests\TestCase;
use function var_dump;

class TodoTest extends TestCase {

    function test_pode_inserir_um_novo_todo() {
        $data = [
            "tarefa" => $this->faker->words(3, true),
            "concluido" => $this->faker->boolean()
        ];

        $todo = new TodoRepository(new Todo);
        $created = $todo->createTodo($data);

        $this->assertInstanceOf(Todo::class, $created);
        $this->assertJson(json_encode($data), $created->toJson());





    }

    function test_erro_ao_criar_um_todo_com_dados_invalidos() {

        $this->expectException(CreateTodoInvalidArgumentException::class);
        $this->expectExceptionCode(500);

        $repo = new TodoRepository(new Todo());
        $repo->createTodo([]);

        $repo->createTodo([
            "tarefa"=> str_repeat('X', 200)
        ]);

        $repo->createTodo([
            "tarefa"=> "Ola mundo",
            "concluido" => "X"
        ]);

    }

    function test_atualizar_um_todo() {

        $todo = factory(Todo::class)->create();
        $repo = new TodoRepository($todo);

        $update = [
            "tarefa" => $this->faker->words(3, true),
            "concluido" => $this->faker->boolean()
        ];

        $updated = $repo->updateTodo($update);

        $this->assertTrue($updated);
        $this->assertDatabaseHas('todos', $update);
    }

    function test_erro_ao_atualizar_um_todo_com_campos_invalidos() {
        $this->expectException(UpdateTodoInvalidArgumentException::class);
        $this->expectExceptionCode(500);

        $todo = factory(Todo::class)->create();

        $repo = new TodoRepository($todo);

        $updated = $repo->updateTodo(["concluido" => null]);

        $this->assertFalse($updated);

    }

    public function test_buscar_um_todo_pelo_id() {

        $repo = new TodoRepository(new Todo());

        $finded = $repo->findTodoById($this->todo->id);

        $this->assertJson($this->todo->toJson(), $finded->toJson());

    }


    public function test_buscar_um_todo_que_nao_existe_pelo_id() {

        $this->expectException(TodoNotFoundException::class);
        $this->expectExceptionCode(404);

        $repo = new TodoRepository(new Todo());

        $repo->findTodoById(9999);

    }

    public function test_retorna_o_model_utilizado() {

        $repo = new TodoRepository($this->todo);
        $model = $repo->getModel();

        $this->assertEquals($this->todo, $model);
    }


    public function test_listar_todos_os_todos() {

        $repo = new TodoRepository(new Todo());

        factory(Todo::class, 99)->create();

        $todos = $repo->listTodos();

        $this->assertEquals($todos->count(), 100);

        $firstItem = $todos->first();
        $lastItem = $todos->last();

        $this->assertEquals(100, $firstItem->id);
        $this->assertEquals(1, $lastItem->id);

    }

    public function test_remover_um_todo() {

        $repo = new TodoRepository($this->todo);

        $deleted = $repo->deleteTodo();

        $this->assertTrue($deleted);

        $this->assertDatabaseHas('todos',$this->todo->toArray());

    }

}
