<?php

namespace Model;

use Database\Database;

abstract class Record
{
    protected $id;

    abstract protected static function getTableName();

    public function getId()
    {
        return $this->id;
    }

    public function setId(string $id)
    {
        $this->id = $id;
    }

    protected function write(): void
    {
        if (!$this->id) {
            $this->id = self::generateId();
            $propertiesArray = $this->databaseFormat();
            $this->insert($propertiesArray);
        } else {
            $propertiesArray = $this->databaseFormat();
            $this->update($propertiesArray);
        }
    }

    private static function generateId(): string
    {
        while (true) {
            $id = bin2hex(random_bytes(64));
            $user = self::findOneById($id);

            if (!$user) {
                return $id;
            }
        }
    }

    private function databaseFormat(): array
    {
        $reflection = new \ReflectionClass($this);
        $properties = $reflection->getProperties();

        foreach ($properties as $property) {
            $propertyName = $property->getName();
            $underscore = self::camelCaseToUnderscore($propertyName);
            $propertiesArray[$underscore] = $this->$propertyName;
        }

        return $propertiesArray;
    }

    private static function camelCaseToUnderscore(string $property): string
    {
        return strtolower(preg_replace('/[A-Z]/', '_$0', lcfirst($property)));
    }

    private static function insert(array $propertiesArray): void
    {
        foreach ($propertiesArray as $column => $value) {
            $parameter = ':' . $column;
            $columns[] = $column;
            $parameters[] = $parameter;
            $parametersToValues[$parameter] = $value;
        }

        $database = Database::getInstance();
        $sql = 'INSERT INTO ' . static::getTableName() . ' (' . implode(', ', $columns) . ') VALUES (' . implode(', ', $parameters) . ');';
        $database->query($sql, $parametersToValues, static::class);
    }

    private static function update(array $propertiesArray): void
    {
        $propertiesArrayFilter = array_filter($propertiesArray);

        foreach ($propertiesArrayFilter as $column => $value) {
            $parameter = ':' . $column;
            $columnsToParameters[] = $column . ' = ' . $parameter;
            $parametersToValues[$parameter] = $value;
        }

        $database = Database::getInstance();
        $sql = 'UPDATE ' . static::getTableName() . ' SET ' . implode(', ', $columnsToParameters) . ' WHERE id = :id;';
        $database->query($sql, $parametersToValues, static::class);
    }

    protected static function findOneById(string $id): ?self
    {
        $database = Database::getInstance();
        $sql = 'SELECT * FROM ' . static::getTableName() . ' WHERE id = :id;';
        $result = $database->query($sql, [':id' => $id], static::class);

        if (!$result) {
            return null;
        }

        return $result[0];
    }
}