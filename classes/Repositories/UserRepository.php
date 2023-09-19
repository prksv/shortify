<?php

namespace Core\Repositories;

use RedBeanPHP\R;
use RedBeanPHP\RedException\SQL;

class UserRepository
{
    public function register(string $login, string $password): array|\RedBeanPHP\OODBBean|null
    {
        $user = R::dispense("users");

        $user->login = $login;
        $user->password = password_hash($password, PASSWORD_BCRYPT);

        try {
            R::store($user);
        } catch (\Throwable $e) {
            return null;
        }

        return $user;
    }

    public function findByLogin(string $login): ?\RedBeanPHP\OODBBean
    {
        return R::findOne("users", "where login = ?", [$login]);
    }

    public function findById(int $id): ?\RedBeanPHP\OODBBean
    {
        return R::findOne("users", "where id = ?", [$id]);
    }
}