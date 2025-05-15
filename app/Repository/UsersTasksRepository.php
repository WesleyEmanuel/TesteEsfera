<?php
namespace App\Repository;

use App\Models\UsersTasks;
use App\Repository\AbstractRepository;

class UsersTasksRepository extends AbstractRepository{
    public function __construct(UsersTasks $task)
    {
        $this->model = $task;
    }
}