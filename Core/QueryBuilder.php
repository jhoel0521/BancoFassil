<?php

namespace Core;

use PDO;
use PDOException;

class QueryBuilder
{
    private $db;
    private $table;
    private $query;
    private $bindings = [];
    private $modelClass = null;
    public function __construct(DB $db, string $table, string $modelClass = '')
    {
        $this->db = $db;
        $this->table = $table;
        $this->query = new \stdClass();
        if (!empty($modelClass)) {
            $this->modelClass = $modelClass;
        }
    }

    public function select(array $columns = ['*'])
    {
        $this->query->type = 'select';
        $this->query->select = implode(', ', $columns);
        return $this;
    }

    public function where(string $column, string $operator, $value)
    {
        if (func_num_args() === 2) {
            $value = $operator;
            $operator = '=';
        }
        if (!is_string($operator)) {
            throw new QueryException('Invalid operator', $this->query);
        }
        $this->query->where[] = "{$column} {$operator} ?";
        $this->bindings[] = $value;
        return $this;
    }

    public function get()
    {
        if (!isset($this->query->select)) {
            $this->query->select = '*';
        }
        $sql = "SELECT {$this->query->select} FROM {$this->table}";
        if (!empty($this->query->where)) {
            $sql .= " WHERE " . implode(' AND ', $this->query->where);
        }
        if (!empty($this->query->orderBy)) {
            $sql .= " {$this->query->orderBy}";
        }
        if (!empty($this->query->limit)) {
            $sql .= " LIMIT {$this->query->limit}";
        }
        $results = $this->db->query($sql, $this->bindings)->fetchAll();
        if ($this->modelClass) {
            $results = array_map(function ($result) {
                $model = new $this->modelClass;
                $model->fill((array) $result);
                return $model;
            }, $results);
        }
        return $results;
    }

    public function first()
    {
        $results = $this->limit(1)->get();
        return $results[0] ?? null;
    }
    public function limit(int $limit)
    {
        $this->query->limit = $limit;
        return $this;
    }
    public function orderBy(string $column, string $direction = 'ASC')
    {
        $this->query->orderBy = "ORDER BY {$column} {$direction}";
        return $this;
    }
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
