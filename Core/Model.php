<?php

namespace Core;
class Model {
    protected $table;
    protected $primaryKey = 'id';
    protected $fillable = [];
    protected $hidden = [];
    protected $timestamps = true;
    protected $softDeletes = false;

    private $attributes = [];
    private $original = [];
    private $exists = false;

    public function __construct(array $attributes = []) {
        $this->fill($attributes);
        
        if (!$this->table) {
            $this->table = strtolower(class_basename($this)) . 's';
        }
    }

    public function fill(array $attributes) {
        foreach ($attributes as $key => $value) {
            if (in_array($key, $this->fillable)) {
                $this->attributes[$key] = $value;
            }
        }
        return $this;
    }

    public function save() {
        $db = DB::getInstance();
        
        if ($this->exists) {
            return $this->performUpdate($db);
        }
        
        return $this->performInsert($db);
    }

    protected function performInsert(DB $db) {
        $attributes = $this->getAttributesForSave();
        
        if ($this->timestamps) {
            $attributes['created_at'] = date('Y-m-d H:i:s');
            $attributes['updated_at'] = date('Y-m-d H:i:s');
        }

        $columns = implode(', ', array_keys($attributes));
        $placeholders = implode(', ', array_fill(0, count($attributes), '?'));
        
        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
        
        $db->query($sql, array_values($attributes));
        
        $this->attributes[$this->primaryKey] = $db->getConnection()->lastInsertId();
        $this->exists = true;
        
        return $this;
    }

    protected function performUpdate(DB $db) {
        $attributes = $this->getAttributesForSave();
        
        if ($this->timestamps) {
            $attributes['updated_at'] = date('Y-m-d H:i:s');
        }

        $updates = [];
        foreach ($attributes as $key => $value) {
            $updates[] = "{$key} = ?";
        }
        
        $sql = "UPDATE {$this->table} SET " . implode(', ', $updates) . 
               " WHERE {$this->primaryKey} = ?";
        
        $bindings = array_values($attributes);
        $bindings[] = $this->getKey();
        
        $db->query($sql, $bindings);
        
        return $this;
    }

    public function delete() {
        if ($this->softDeletes) {
            return $this->performSoftDelete();
        }
        return $this->performForceDelete();
    }

    protected function performForceDelete() {
        $db = DB::getInstance();
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?";
        $db->query($sql, [$this->getKey()]);
        $this->exists = false;
        return true;
    }

    protected function performSoftDelete() {
        $this->attributes['deleted_at'] = date('Y-m-d H:i:s');
        return $this->save();
    }

    public static function find($id) {
        $instance = new static();
        return $instance->newQuery()->where($instance->primaryKey, '=', $id)->first();
    }

    public static function all() {
        return (new static())->newQuery()->get();
    }

    protected function newQuery() {
        return DB::getInstance()->table($this->table);
    }

    // Métodos mágicos y helpers adicionales...
}