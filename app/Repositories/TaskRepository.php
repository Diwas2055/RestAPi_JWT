<?php

namespace App\Repositories;

use App\Models\Task;
use Illuminate\Support\Facades\Validator;

class TaskRepository
{
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function getAllTasks()
    {
        return  $this->task::all();
    }

    public function getTaskById($TaskId)
    {
        return  $this->task::findOrFail($TaskId);
    }

    public function deleteTask($TaskId)
    {
        $this->task::destroy($TaskId);
    }

    public function deleteMultipleTask($TaskId)
    {
        $this->task::whereIn('id',explode(",",$TaskId))->delete();
    }

    public function createTask(array $TaskDetails)
    {
        return  $this->task::create($TaskDetails);
    }

    public function updateTask($TaskId, array $newDetails)
    {
       $model= $this->getTaskById($TaskId);
       $model->update($newDetails);
       return $model;
    }

    public function searchable($data)
    {
        if (isset($data['id']) && !empty($data['id'])) {
          $this->task = $this->task->where('id', $data['id']);
        }
        if ((isset($data['form_date']) && empty($data['form_date'])) || (isset($data['to_date']) && empty($data['to_date']))) {
          $this->task  = $this->task->whereBetween('started_at', [$data['form_date'] ?? ' ', $data['to_date'] ?? ' ']);
        }
        return $this->task->get() ;
    }

    public function validated($data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:6000',
            'status' => 'in:active,inactive',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
         return $validator->validated();
    }
}
