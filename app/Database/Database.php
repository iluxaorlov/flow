<?php

namespace App\Database;

class Database
{
    private $pdo;
    private static $instance;

    public function __construct()
    {
        $settings = require_once __DIR__ . '/../Settings/Database.php';

        $this->pdo = new \PDO('mysql:host=' . $settings['host'] . ';dbname=' . $settings['dbname'],
            $settings['user'],
            $settings['pass']
        );
        $this->pdo->exec('SET NAMES utf8mb4');
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function query(string $sql, array $parameters = [], $className = 'stdClass')
    {
        $prepare = $this->pdo->prepare($sql);
        $execute = $prepare->execute($parameters);

        if (!$execute) {
            return null;
        }

        $result = $prepare->fetchAll(\PDO::FETCH_CLASS, $className);

        if (!$result) {
            return null;
        }

        return $result;
    }
}