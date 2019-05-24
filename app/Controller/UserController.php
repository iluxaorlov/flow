<?php

namespace Controller;

use Model\Users;

class UserController extends AbstractController
{
    public function register()
    {
        if ($_POST) {
            try {
                $user = Users::register($_POST);
                $this->login($_POST);
                return;
            } catch (\Exceptions\InvalidArgumentException $error) {
                $this->view->render('user' . DIRECTORY_SEPARATOR . 'register.php', [
                    'title' => 'Регистрация • Flow',
                    'error' => $error->getMessage()
                ]);
                return;
            }
        }

        $this->view->render('user' . DIRECTORY_SEPARATOR . 'register.php', [
            'title' => 'Регистрация • Flux'
        ]);
    }

    public function login()
    {
        if ($_POST) {
            try {
                $user = Users::login($_POST);
                self::setCookie($user);
                header('Location: /');
                return;
            } catch (\Exceptions\InvalidArgumentException $error) {
                $this->view->render('user' . DIRECTORY_SEPARATOR . 'login.php', [
                    'title' => 'Войти • Flow',
                    'error' => $error->getMessage()
                ]);
                return;
            }
        }

        $this->view->render('user' . DIRECTORY_SEPARATOR . 'login.php', [
            'title' => 'Войти • Flux'
        ]);
    }

    private static function setCookie(Users $user)
    {
        $token = $user->getToken();
        setcookie('flux', $token, time() + (365 * 24 * 60 * 60), '/', '', false, true);
    }

    public static function findUserByToken(): ?Users
    {
        $token = $_COOKIE['flux'] ?? '';

        if ($token) {
            $user = Users::findOneByToken($token);
            return $user;
        } else {
            return null;
        }
    }
}