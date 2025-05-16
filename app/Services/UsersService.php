<?php

namespace App\Services;

use App\Repository\TasksRepository;
use App\Repository\UsersRepository;

class UsersService{
    private $usersRepository;
    private $tasksRepository;
    
    public function __construct(UsersRepository $usersRepository, TasksRepository $tasksRepository)
    {
        $this->usersRepository = $usersRepository;
        $this->tasksRepository = $tasksRepository;
    }

    public function createUser($user){
        return $this->usersRepository->create($user);
    }

    public function getUserByEmail(string $email){
        return $this->usersRepository->find($email, 'email')[0];
    }
    
    public function getAllUsers(){
        return $this->usersRepository->allPaginated();
    }

    public function updateUser($id, $user){
        return $this->usersRepository->update($id, $user);
    }

    public function deleteUser($id){
        $existingTasksUser = $this->tasksRepository->getTasksByUserId($id);
        
        if(count($existingTasksUser)){
            return ['error' => true, 'message' => 'Não é permitido excluir usuários com tarefas vinculadas.'];
        }
        
        $resp = $this->usersRepository->delete($id);

        return ['success' => true, 'data' => $resp];
    }
}