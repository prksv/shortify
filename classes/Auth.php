<?php

namespace Core;

session_start();

class Auth
{
    public \RedBeanPHP\OODBBean|null $user = null;

    public function __construct()
    {
        $user = new User();

        if (isset($_SESSION['user'])) {
            $this->user = $user->findById($_SESSION['user']['id']);
        }
    }

    public function check(): bool
    {
        if (!$this->user) {
            return false;
        }
        return true;
    }

    public function setUser($user): Auth
    {
        $_SESSION['user'] = $user;

        $this->user = $user;

        return $this;
    }
}