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
        return $this->tasksRepository->all();
    }
    
    public function filterTasks(array $filters)
    {
        return $this->tasksRepository->filterTasks($filters);
    }

    public function getTasksByUserId(string $id){
        return $this->tasksRepository->getTasksByUserId($id);
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

    public function getUsersByTaskId(string $id){
        return $this->tasksRepository->getUsersByTaskId($id);
    }

    public function updateTask(string $id, array $task)
    {
        return $this->tasksRepository->update($id, $task);
    }

    public function linkUserToTaskTask(string $task, string $user)
    {

        $existingUserTask = $this->usersTasksRepository->existingUserTask($task, $user);
        
        if(count($existingUserTask)){
            return;
        }
            
        return $this->usersTasksRepository->create(['user_id'=>$user, 'task_id'=>$task]);
    }

    public function unlinkUserTask($task, $user){
        return $this->usersTasksRepository->unlinkUserTask($task, $user);
    }

    public function deleteTask(string $id){
        return $this->tasksRepository->delete($id);
    }
}