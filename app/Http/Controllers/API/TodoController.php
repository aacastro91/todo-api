<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseObject;
use App\Http\Controllers\Controller;
use App\Main\Todo\Repositories\Interfaces\TodoRepositoryInterface;
use App\Main\Todo\Repositories\TodoRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use function response;

class TodoController extends Controller {


    private $todoRepo;

    /**
     * TodoController constructor.
     * @param $todoRepository
     */
    public function __construct(TodoRepositoryInterface $todoRepository) {
        $this->todoRepo = $todoRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() {

        $todos = $this->todoRepo->listTodos();
        return response()->json(new ResponseObject($todos));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request) {

        $validatedData = $request->validate([
            'tarefa' => 'required|max:150', 'concluido' => 'boolean',
        ]);

        $res = $this->todoRepo->createTodo($validatedData);
        return response()->json(new ResponseObject($res), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id) {
        $todo = $this->todoRepo->findTodoById($id);
        return response()->json(new ResponseObject($todo));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id) {

        $validatedData = $request->validate([
            'tarefa' => 'required|max:255', 'concluido' => 'required|boolean',
        ]);

        $todo = $this->todoRepo->findTodoById($id);

        $update = new TodoRepository($todo);

        $result = $update->updateTodo($validatedData);

        $newTodo = $update->getModel();
        return response()->json(new ResponseObject($newTodo), Response::HTTP_OK);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id) {

        $todo = $this->todoRepo->findTodoById($id);

        $todoRepo = new TodoRepository($todo);
        $todoRepo->deleteTodo();
        return response()->json(new ResponseObject(null), Response::HTTP_NO_CONTENT);

    }
}
