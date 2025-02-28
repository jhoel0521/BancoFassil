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
                    'password' => $_ENV['DB_PASS'] ?? '',
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

    public function table(string $table, string $modelClass = '')
    {
        return new QueryBuilder($this, $table, $modelClass);
    }
    public function getConnection()
    {
        return $this->connection;
    }
}




// Excepciones personalizadas
class DatabaseException extends \RuntimeException {}
