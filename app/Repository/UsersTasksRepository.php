<?php
namespace App\Repository;

use App\Models\UsersTasks;
use App\Repository\AbstractRepository;

class UsersTasksRepository extends AbstractRepository{
    public function __construct(UsersTasks $task)
    {
        $this->model = $task;
    }

    public function existingUserTask($task, $user){
        return $this->model
            ->where('user_id', $user)
            ->where('task_id', $task)
            ->get();
    }

    public function unlinkUserTask($task, $user){
        return $this->model
            ->where('user_id', $user)
            ->where('task_id', $task)
            ->delete();
    }
}