<?php

require_once __DIR__ . '/../config/Database.php';

abstract class BaseDAO
{
    protected PDO $connection;
    protected string $table;
    protected string $primaryKey;
    protected array $allowedFields;

    public function __construct()
    {
        $this->connection = Database::connect();
    }

    public function getAll(): array
    {
        $sql = "SELECT * FROM {$this->table}";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getById(int $id): array|false
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute(['id' => $id]);

        return $stmt->fetch();
    }

    public function create(array $data): string
    {
        $data = $this->filterAllowedFields($data);

        if (empty($data)) {
            throw new InvalidArgumentException('No valid fields provided.');
        }

        $columns = array_keys($data);
        $placeholders = array_map(fn($field) => ':' . $field, $columns);

        $sql = "INSERT INTO {$this->table} (" .
            implode(', ', $columns) .
            ") VALUES (" .
            implode(', ', $placeholders) .
            ")";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute($data);

        return $this->connection->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $data = $this->filterAllowedFields($data);

        if (empty($data)) {
            throw new InvalidArgumentException('No valid fields provided.');
        }

        $setParts = [];

        foreach ($data as $field => $value) {
            $setParts[] = "{$field} = :{$field}";
        }

        $sql = "UPDATE {$this->table} SET " .
            implode(', ', $setParts) .
            " WHERE {$this->primaryKey} = :id";

        $data['id'] = $id;

        $stmt = $this->connection->prepare($sql);

        return $stmt->execute($data);
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id";

        $stmt = $this->connection->prepare($sql);

        return $stmt->execute(['id' => $id]);
    }

    protected function filterAllowedFields(array $data): array
    {
        return array_intersect_key(
            $data,
            array_flip($this->allowedFields)
        );
    }
}
