<?php

namespace App\Main\Todo\Repositories\Interfaces;

use App\main\Todo\Todo;
use Illuminate\Support\Collection as Support;
use Jsdecena\Baserepo\BaseRepositoryInterface;

interface TodoRepositoryInterface extends BaseRepositoryInterface
{
    public function listTodos(string $order = 'id', string $sort = 'desc', array $columns = ['*']) : Support;

    public function createTodo(array $params) : Todo;

    public function updateTodo(array $params) : bool;

    public function findTodoById(int $id) : Todo;

    public function deleteTodo() : bool;
}
