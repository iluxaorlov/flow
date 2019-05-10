<?php

namespace Model;

use Database\Database;

class User extends Record
{
    protected $login;
    protected $password;
    protected $token;

    protected static function getTableName(): string
    {
        return 'users';
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function setLogin(string $login)
    {
        $this->login = $login;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function setToken(string $token)
    {
        $this->token = $token;
    }

    public static function register(array $requestFields): self
    {
        $login = htmlentities(strtolower(trim($requestFields['login'])));
        $password = htmlentities($requestFields['password']);

        if (!$login) {
            throw new \Exceptions\InvalidArgumentException('Заполните все поля');
        }

        if (!preg_match('/^[a-zA-Z0-9]+$/', $login)) {
            throw new \Exceptions\InvalidArgumentException('Логин должен содержать только латинские буквы и цифры');
        }

        if (self::findOneByLogin($login)) {
            throw new \Exceptions\InvalidArgumentException('Пользователь с таким логином уже существует');
        }

        if (!$password) {
            throw new \Exceptions\InvalidArgumentException('Заполните все поля');
        }

        if (mb_strlen($password) < 8) {
            throw new \Exceptions\InvalidArgumentException('Пароль должен состоять минимум из восьми символов');
        }

        $user = new self;
        $user->login = $login;
        $user->password = password_hash($password, PASSWORD_DEFAULT);
        $user->token = self::generateToken();
        $user->write();
        return $user;
    }

    public static function login(array $requestFields): self
    {
        $login = htmlentities(strtolower(trim($requestFields['login'])));
        $password = htmlentities($requestFields['password']);

        if (!$login) {
            throw new \Exceptions\InvalidArgumentException('Заполните все поля');
        }

        if (!$password) {
            throw new \Exceptions\InvalidArgumentException('Заполните все поля');
        }

        $user = self::findOneByLogin($login);

        if (!$user) {
            throw new \Exceptions\InvalidArgumentException('Неверный логин или пароль');
        }

        if (!password_verify($password, $user->getPassword())) {
            throw new \Exceptions\InvalidArgumentException('Неверный логин или пароль');
        }

        $user->token = self::generateToken();
        $user->write();
        return $user;
    }

    private static function generateToken(): string
    {
        $token = bin2hex(random_bytes(16));

        if (self::findOneByToken($token)) {
            return self::generateToken();
        } else {
            return $token;
        }
    }

    private static function findOneByLogin(string $login): ?self
    {
        $database = Database::getInstance();
        $sql = 'SELECT * FROM ' . self::getTableName() . ' WHERE login = :login;';
        $result = $database->query($sql, [':login' => $login], self::class);

        if (!$result) {
            return null;
        }

        return $result[0];
    }

    public static function findOneByToken(string $token): ?self
    {
        $database = Database::getInstance();
        $sql = 'SELECT * FROM ' . self::getTableName() . ' WHERE token = :token;';
        $result = $database->query($sql, [':token' => $token], self::class);

        if (!$result) {
            return null;
        }

        return $result[0];
    }
}