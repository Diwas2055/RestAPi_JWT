<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Repositories\TaskRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;



class TaskController extends Controller
{
    public function __construct(TaskRepository $taskRepository, Task $task)
    {
        $this->middleware('jwt.verify');
        $this->taskRepository = $taskRepository;
        $this->task = $task;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchable = $request->only('id', 'form_date', 'to_date');

        $query = DB::table('tasks');
        $query = $this->taskRepository->searchable($searchable);
        return response()->json(
            $query,
            Response::HTTP_OK
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:6000',
            'status' => 'in:active,inactive',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $data = $validator->validated();
        $data['user_id'] = auth()->user()->id;
        $data['started_at'] = date('Y-m-d');
        $task = $this->taskRepository->createTask($data);
        if ($task) {
            return response()->json($task, Response::HTTP_CREATED);
        } else {
            return response()->json(['message' => 'Error while creating task'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = $this->taskRepository->getTaskById($id);
        if ($task) {
            return response()->json($task, Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'Task not found'], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->taskRepository->getTaskById($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:6000',
            'status' => 'in:active,inactive',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $data = $validator->validated();
        $task = $this->taskRepository->updateTask($id, $data);
        if ($task) {
            return response()->json($task, Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'Error while updating task'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->taskRepository->deleteTask($id);
        return response()->json([
            'success' => true,
            'message' => 'Task deleted successfully'
        ], Response::HTTP_OK);
    }

    public function destroyMultiple(Request $request)
    {
        $ids = $request->input('id');
        if ($ids) {
            $this->taskRepository->deleteMultipleTask($ids);
            return response()->json([
                'success' => true,
                'message' => 'Multiple Tasks deleted successfully'
            ], Response::HTTP_OK);
        }
        return response()->json([
            'success' => false,
            'message' => 'Please select at least one task'
        ], Response::HTTP_OK);
    }
}
