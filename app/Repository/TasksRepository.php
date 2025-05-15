<?php
namespace App\Repository;
use App\Models\Task;
use App\Models\User;
use App\Repository\AbstractRepository;

class TasksRepository extends AbstractRepository{
    public function __construct(Task $task)
    {
        $this->model = $task;
    }

    public function getTasksByUserId($userId)
    {
        return $this->model->join('users_tasks', 'tasks.id', '=', 'users_tasks.task_id')
            ->where('users_tasks.user_id', $userId)
            ->select('tasks.*')
            ->orderBy('tasks.created_at', 'desc')
            ->get();
    }

    public function getUsersByTaskId($taskId)
    {
        return User::join('users_tasks', 'users.id', '=', 'users_tasks.user_id')
            ->where('users_tasks.task_id', $taskId)
            ->select('users.*')
            ->orderBy('users.name', 'asc')
            ->get();
    }
}