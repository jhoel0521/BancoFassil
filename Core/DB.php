<?php

namespace Core;

use PDO;
use PDOException;

class DB
{
    private static $instance = null;
    private $connection;
    private $config;

    private function __construct(array $config)
    {
        $this->config = $config;
        $this->connect();
    }

    public static function getInstance(array $config = null)
    {
        if (!self::$instance) {
            if (!$config) {
                $config = [
                    'driver' => $_ENV['DB_DRIVER'] ?? 'mysql',
                    'host' => $_ENV['DB_HOST'] ?? 'localhost',
                    'database' => $_ENV['DB_NAME'] ?? 'bancofassil',
                    'username' => $_ENV['DB_USER'] ?? 'root',
                    'password' => $_ENV['DB_PASS'] ?? '123456789',
                    'charset' => 'utf8mb4',
                    'collation' => 'utf8mb4_unicode_ci',
                    'prefix' => '',
                ];
            }
            self::$instance = new self($config);
        }
        return self::$instance;
    }

    private function connect()
    {
        try {
            $this->connection = new PDO(
                "{$this->config['driver']}:host={$this->config['host']};dbname={$this->config['database']};charset={$this->config['charset']}",
                $this->config['username'],
                $this->config['password'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        } catch (PDOException $e) {
            throw new DatabaseException("Error de conexión: " . $e->getMessage());
        }
    }

    public function query(string $sql, array $params = [])
    {
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            throw new QueryException("Error en la consulta: " . $e->getMessage(), $sql);
        }
    }

    public function table(string $table)
    {
        return new QueryBuilder($this, $table);
    }

    public function getConnection()
    {
        return $this->connection;
    }
}

class QueryBuilder
{
    private $db;
    private $table;
    private $query;
    private $bindings = [];

    public function __construct(DB $db, string $table)
    {
        $this->db = $db;
        $this->table = $table;
        $this->query = new \stdClass();
    }

    public function select(array $columns = ['*'])
    {
        $this->query->type = 'select';
        $this->query->select = implode(', ', $columns);
        return $this;
    }

    public function where(string $column, string $operator, $value)
    {
        $this->query->where[] = "{$column} {$operator} ?";
        $this->bindings[] = $value;
        return $this;
    }

    public function get()
    {
        $sql = "SELECT {$this->query->select} FROM {$this->table}";

        if (!empty($this->query->where)) {
            $sql .= " WHERE " . implode(' AND ', $this->query->where);
        }

        return $this->db->query($sql, $this->bindings)->fetchAll();
    }

    public function first()
    {
        $results = $this->limit(1)->get();
        return $results[0] ?? null;
    }

    // Implementar más métodos (join, orderBy, groupBy, etc.)
}



// Excepciones personalizadas
class DatabaseException extends \RuntimeException
{
}
class QueryException extends \RuntimeException
{
    public $sql;

    public function __construct($message, $sql)
    {
        $this->sql = $sql;
        parent::__construct($message);
    }
}