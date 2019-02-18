<?php

namespace App\Main\Todo\Repositories;

use App\Main\Todo\Exceptions\CreateTodoInvalidArgumentException;
use App\Main\Todo\Exceptions\TodoNotFoundException;
use App\Main\Todo\Exceptions\UpdateTodoInvalidArgumentException;
use App\Main\Todo\Repositories\Interfaces\TodoRepositoryInterface;
use App\main\Todo\Todo;
use function collect;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection as Support;
use Jsdecena\Baserepo\BaseRepository;

class TodoRepository extends BaseRepository implements TodoRepositoryInterface {


    /**
     * TodoRepository constructor.
     */
    public function __construct(Todo $todo) {
        parent::__construct($todo);
        $this->model = $todo;
    }

    public function getModel() {
        return $this->model;
    }

    public function listTodos(string $order = 'id', string $sort = 'desc', array $columns = ['*']): Support {
        return $this->all($columns, $order, $sort);
    }

    /**
     * Create the todo
     *
     * @param array $params
     * @return Todo
     * @throws CreateTodoInvalidArgumentException
     */
    public function createTodo(array $params): Todo {
        try {
            $data = collect($params)->all();

            $todo = new Todo($data);

            $todo->save();

            return $todo;
        } catch (QueryException $e) {
            throw new CreateTodoInvalidArgumentException($e->getMessage(), 500, $e);
        }
    }

    /**
     * Update the todo
     *
     * @param array $params
     *
     * @return bool
     * @throws UpdateTodoInvalidArgumentException
     */
    public function updateTodo(array $params): bool {
        try {
            return $this->model->update($params);
        } catch (QueryException $e) {
            throw new UpdateTodoInvalidArgumentException($e->getMessage(), 500, $e);
        }
    }

    /**
     * Find the todo or fail
     *
     * @param int $id
     *
     * @return Todo
     * @throws TodoNotFoundException
     */
    public function findTodoById(int $id): Todo {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new TodoNotFoundException($e->getMessage(),404, $e);
        }
    }

    /**
     * Delete a todo
     *
     * @return bool
     * @throws \Exception
     */
    public function deleteTodo(): bool {
        return $this->delete();
    }
}
