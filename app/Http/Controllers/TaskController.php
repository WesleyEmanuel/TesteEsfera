<?php

namespace App\Http\Controllers;

use App\Services\TasksService;
use App\Services\UsersService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    private $tasksService;
    private $usersService;

    public function __construct(TasksService $tasksService, UsersService $usersService)
    {
        $this->tasksService = $tasksService;
        $this->usersService = $usersService;
    }

    public function index()
    {
        $id = auth()->user()->id;

        if(count(request()->all())){
            $filters = request()->all();
            unset($filters['_token']);
            unset($filters['_method']);
            unset($filters['page']);
            
            if(isset($filters['user']) && $filters['user'] != 'all'){
                $filters['users_tasks.user_id'] = $filters['user'];
            }

            if(isset($filters['status']) && $filters['status'] == 'all'){
                unset($filters['status']);
            }
            
            unset($filters['user']);
        }

        if(isset($filters)){
            $tasks = $this->tasksService->filterTasks($filters);
        } else{
            $tasks = $this->tasksService->getTasksByUserId($id);
        }
        
        $users = $this->usersService->getAllUsers();

        return view('dashboard', ['tasks' => $tasks, 'users' => $users]);
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
        
        return redirect()->route('tasks.index')->with('success', 'Tarefa criada com sucesso');
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

        $usersTask = $this->tasksService->getUsersByTaskId($id);
        $users = $this->usersService->getAllUsers();

        return view('tasks.edit', ['task'=>$task, 'usersTask' => $usersTask, 'users'=>$users]);
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

        return redirect()->route('tasks.index')->with('success', 'Tarefa atualizada com sucesso');
    }

    public function userTask(string $taskId, Request $request){
        $userId = $request->input('users');

        $this->tasksService->linkUserToTaskTask($taskId, $userId);

        return $this->edit($taskId);
    }

    public function unlinkUserTask($task, $user){
        $this->tasksService->unlinkUserTask($task, $user);

        return $this->edit($task);
    }

    public function destroy(string $id)
    {
        $this->tasksService->deleteTask($id);
        return redirect()->route('tasks.index')->with('success', 'Tarefa deletada com sucesso');
    }
}
