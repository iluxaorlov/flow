<?php

namespace Model;

use Model\Users;
use Database\Database;

class Messages extends Record
{
    protected $user;
    protected $text;
    protected $date;

    public static function getTableName(): string
    {
        return 'messages';
    }

    public function getUser(): Users
    {
        return Users::findOneById($this->user);
    }

    public function setUser(Users $user)
    {
        $this->user = $user->getId();
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text)
    {
        $this->text = $text;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function setDate(string $date)
    {
        $this->date = $date;
    }

    public function send(Users $user, string $text): self
    {
        $message = new self;
        $message->setUser($user);
        $message->setText(self::formatText($text));
        $message->setDate(date('Y-m-d H:i:s'));
        $message->write();
        return $message;
    }

    private static function formatText(string $text): ?string
    {
        $text = trim($text);
        $text = preg_replace('/[\n\s]+/', ' ', $text);
        $text = substr($text, 0, 512);
        $text = htmlentities($text);

        if (!$text) {
            return null;
        }

        return $text;
    }

    public static function pull(int $limit): ?array
    {
        $database = Database::getInstance();
        $sql = 'SELECT * FROM ' . static::getTableName() . ' ORDER BY date DESC LIMIT ' . $limit . ';';
        $result = $database->query($sql, [], static::class);

        if (!$result) {
            return null;
        }

        return $result;
    }

    public static function countPull(): int
    {
        $database = Database::getInstance();
        $sql = 'SELECT COUNT(*) AS pull FROM ' . static::getTableName() . ';';
        $result = $database->query($sql, [], static::class)[0];
        return $result->pull;
    }

    public static function load(int $limit, int $offset): ?array
    {
        $database = Database::getInstance();
        $sql = 'SELECT * FROM ' . static::getTableName() . ' ORDER BY date DESC LIMIT ' . $limit . ' OFFSET ' . $offset . ';';
        $result = $database->query($sql, [], static::class);

        if (!$result) {
            return null;
        }

        return $result;
    }
}