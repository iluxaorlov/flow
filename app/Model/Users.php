<?php

namespace App\Model;

use App\Database\Database;

class Users extends Record
{
    protected $nickname;
    protected $password;
    protected $token;

    protected static function getTableName(): string
    {
        return 'users';
    }

    public function getNickname(): string
    {
        return $this->nickname;
    }

    public function setNickname(string $nickname)
    {
        $this->nickname = $nickname;
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
        $nickname = htmlentities(strtolower(trim($requestFields['nickname'])));
        $password = htmlentities($requestFields['password']);
        $repeat = htmlentities($requestFields['repeat']);

        if (!$nickname) {
            throw new \App\Exceptions\InvalidArgumentException('Заполните все поля');
        }

        if (!preg_match('/^[a-zA-Z0-9]+$/', $nickname)) {
            throw new \App\Exceptions\InvalidArgumentException('Имя должно содержать только латинские буквы и цифры');
        }

        if (self::findOneByNickname($nickname)) {
            throw new \App\Exceptions\InvalidArgumentException('Пользователь с таким именем уже существует');
        }

        if (!$password) {
            throw new \App\Exceptions\InvalidArgumentException('Заполните все поля');
        }

        if (mb_strlen($password) < 8) {
            throw new \App\Exceptions\InvalidArgumentException('Пароль должен состоять минимум из восьми символов');
        }

        if ($password !== $repeat) {
            throw new \App\Exceptions\InvalidArgumentException('Пароли не совпадают');
        }

        $user = new self;
        $user->nickname = $nickname;
        $user->password = password_hash($password, PASSWORD_DEFAULT);
        $user->token = self::generateToken();
        $user->write();
        return $user;
    }

    public static function login(array $requestFields): self
    {
        $nickname = htmlentities(strtolower(trim($requestFields['nickname'])));
        $password = htmlentities($requestFields['password']);

        if (!$nickname) {
            throw new \App\Exceptions\InvalidArgumentException('Заполните все поля');
        }

        if (!$password) {
            throw new \App\Exceptions\InvalidArgumentException('Заполните все поля');
        }

        $user = self::findOneByNickname($nickname);

        if (!$user) {
            throw new \App\Exceptions\InvalidArgumentException('Неверный логин или пароль');
        }

        if (!password_verify($password, $user->getPassword())) {
            throw new \App\Exceptions\InvalidArgumentException('Неверный логин или пароль');
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

    private static function findOneByNickname(string $nickname): ?self
    {
        $database = Database::getInstance();
        $sql = 'SELECT * FROM ' . self::getTableName() . ' WHERE nickname = :nickname;';
        $result = $database->query($sql, [':nickname' => $nickname], self::class);

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