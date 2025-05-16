<?php

namespace App\Repository;

use App\Models\Task;
use App\Models\User;
use App\Repository\AbstractRepository;

class TasksRepository extends AbstractRepository
{
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
            ->paginate(10);
    }

    public function getUsersByTaskId($taskId)
    {
        return User::join('users_tasks', 'users.id', '=', 'users_tasks.user_id')
            ->where('users_tasks.task_id', $taskId)
            ->select('users.*')
            ->orderBy('users.name', 'asc')
            ->paginate(10);
    }

    public function filterTasks(array $filters)
    {
        $query = $this->model->join('users_tasks', 'tasks.id', '=', 'users_tasks.task_id');

        foreach ($filters as $key => $value) {
            if (!is_null($value) && $value !== '') {
                if ($key == 'title') {
                    $query->where('title', 'like', '%' . $value . '%');
                } else {
                    $query->where($key, $value);
                }
            }
        }
        
        return $query->select([
            'tasks.id',
            'tasks.title',
            'tasks.description',
            'tasks.status',
            'users_tasks.user_id as user',
        ])->orderBy('tasks.created_at', 'desc')->paginate(10);
    }
}
