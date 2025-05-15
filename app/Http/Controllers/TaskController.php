<?php

namespace App\Http\Controllers;

use App\Services\TasksService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    private $tasksService;

    public function __construct(TasksService $tasksService)
    {
        $this->tasksService = $tasksService;
    }

    public function index()
    {
        $tasks = $this->tasksService->getAllTasks();

        return view('dashboard', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|min:3|max:200',
            'description' => 'nullable|string|max:500',
            'status' => 'required|in:pending,completed',
        ]);

        $task = [
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
        ];

        $this->tasksService->createTask($task);
        
        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $task = $this->tasksService->getTaskById($id);

        if (!$task) {
            return redirect()->route('tasks.index')->with('error', 'Task not found.');
        }

        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|min:3|max:200',
            'description' => 'nullable|string|max:500',
            'status' => 'required|in:pending,completed',
        ]);

        $task = [
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
        ];

        $this->tasksService->updateTask($id, $task);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function destroy(string $id)
    {
        //
    }
}
