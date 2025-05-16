<?php
namespace App\Repository;
use App\Models\User;
use App\Repository\AbstractRepository;

class UsersRepository extends AbstractRepository{
    public function __construct(User $user)
    {
        $this->model = $user;
    }
}