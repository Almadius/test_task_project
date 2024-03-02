<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index(Request $request): \Illuminate\Support\Collection
    {
        return $this->taskService->getAll($request);
    }

    public function show($id)
    {
        return $this->taskService->getById($id);
    }

    public function store(TaskRequest $request)
    {
        return $this->taskService->create($request->validated());
    }

    public function update(TaskRequest $request, $id)
    {
        $task = $this->taskService->getById($id);
        return $this->taskService->update($task, $request->validated());
    }

    public function destroy($id)
    {
        $task = $this->taskService->getById($id);
        return $this->taskService->delete($task);
    }
}
