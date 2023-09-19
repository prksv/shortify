<?php

namespace Core;

require_once __DIR__ . '/../database.php';

use Core\Repositories\UserRepository;
use RedBeanPHP\OODBBean;

class User
{
    private UserRepository $repository;

    public function __construct()
    {
        $this->repository = new UserRepository();
    }

    public function register(string $login, string $password): array|OODBBean|null
    {
        return $this->repository->register($login, $password);
    }

    public function login(string $login, string $password): OODBBean|bool
    {
        $user = $this->repository->findByLogin($login);

        if (!$user) return false;

        $password_matches = password_verify($password, $user->password);

        return $password_matches ? $user : false;
    }

    public function findById(int $id): bool|OODBBean|null
    {
        $user = $this->repository->findById($id);

        if (!$user) return false;

        return $user;
    }
}