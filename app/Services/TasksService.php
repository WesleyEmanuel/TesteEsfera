<?php

namespace App\Services;

use App\Models\UsersTasks;
use App\Repository\TasksRepository;
use App\Repository\UsersTasksRepository;

class TasksService{
    private $tasksRepository;
    private $usersTasksRepository;
    
    public function __construct(TasksRepository $tasksRepository, UsersTasksRepository $usersTasksRepository)
    {
        $this->usersTasksRepository = $usersTasksRepository;
        $this->tasksRepository = $tasksRepository;
    }

    public function getAllTasks()
    {
        return $this->tasksRepository->getTasksByUserId(auth()->user()->id);
    }

    public function getTaskById(string $id)
    {
        return $this->tasksRepository->find($id);
    }

    public function createTask(array $task)
    {
        $response = $this->tasksRepository->create($task);

        if ($response->id) {
            $userTask = [
                'user_id' => auth()->user()->id,
                'task_id' => $response->id,
            ];

            $this->usersTasksRepository->create($userTask);
        }
        
        return $response;
    }

    public function updateTask(string $id, array $task)
    {
        return $this->tasksRepository->update($id, $task);
    }
}