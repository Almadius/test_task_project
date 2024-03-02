<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class TaskService
{
    public function getAll(Request $request): Collection
    {
        $query = Task::query();

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('date')) {
            $query->whereDate('date', $request->input('date'));
        }

        return $query->get();
    }

    public function getById($id)
    {
        return Task::findOrFail($id);
    }

    public function create($data)
    {
        return Task::create($data);
    }

    public function update(Task $task, $data)
    {
        $task->update($data);
        return $task;
    }

    public function delete(Task $task)
    {
        $task->delete();
        return $task;
    }
}
