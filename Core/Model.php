<?php

namespace Core;

class Model
{
    protected $table;
    protected $primaryKey = 'id';
    protected $fillable = [];
    protected $hidden = [];
    protected $timestamps = true;
    protected $softDeletes = false;

    private $attributes = [];
    private $original = [];
    private $exists = false;

    public function __construct(array $attributes = [])
    {
        $this->fill($attributes);

        if (!$this->table) {
            $this->table = strtolower(class_basename($this)) . 's';
        }
    }

    public function fill(array $attributes)
    {
        foreach ($attributes as $key => $value) {
            if (in_array($key, $this->fillable)) {
                $this->attributes[$key] = $value;
                $this->$key = $value;
            }
        }
        if (array_key_exists($this->primaryKey, $attributes)) {
            $this->attributes[$this->primaryKey] = $attributes[$this->primaryKey];
            $this->{$this->primaryKey} = $attributes[$this->primaryKey];
            $this->exists = true; 
        }
        return $this;
    }

    public function save()
    {
        $db = DB::getInstance();

        if ($this->exists) {
            return $this->performUpdate($db);
        }

        return $this->performInsert($db);
    }

    protected function performInsert(DB $db)
    {
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

    protected function performUpdate(DB $db)
    {
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

    public function delete()
    {
        if ($this->softDeletes) {
            return $this->performSoftDelete();
        }
        return $this->performForceDelete();
    }

    protected function performForceDelete()
    {
        $db = DB::getInstance();
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?";
        $db->query($sql, [$this->getKey()]);
        $this->exists = false;
        return true;
    }
    public function getKey()
    {
        return $this->attributes[$this->primaryKey] ?? null;
    }

    protected function performSoftDelete()
    {
        $this->attributes['deleted_at'] = date('Y-m-d H:i:s');
        return $this->save();
    }

    protected function newQuery()
    {
        return DB::getInstance()->table($this->table, static::class);
    }
    protected function getAttributesForSave()
    {
        $attributes = [];

        // Solo incluir campos fillable
        foreach ($this->fillable as $field) {
            if (array_key_exists($field, $this->attributes)) {
                $attributes[$field] = $this->attributes[$field];
            }
        }

        // Manejo de timestamps
        if ($this->timestamps) {
            if (!$this->exists) {
                $attributes['created_at'] = $this->attributes['created_at'] ?? date('Y-m-d H:i:s');
            }
            $attributes['updated_at'] = date('Y-m-d H:i:s');
        }

        // Manejo de soft deletes
        if ($this->softDeletes && isset($this->attributes['deleted_at'])) {
            $attributes['deleted_at'] = $this->attributes['deleted_at'];
        }

        return $attributes;
    }
    public function __get($name)
    {
        if (array_key_exists($name, $this->attributes)) {
            return $this->attributes[$name];
        }
        if (method_exists($this, $name)) {
            return $this->$name();
        }
        return null;
    }

    public function __set($name, $value)
    {
        if (in_array($name, $this->fillable)) {
            $this->attributes[$name] = $value;
        }
    }
    public function getAttributes()
    {
        return $this->attributes;
    }

    public function getFillable()
    {
        return $this->fillable;
    }
    public static function query()
    {
        $instance = new static();
        return DB::getInstance()->table($instance->table, static::class);
    }

    public static function where($column, $operator, $value = null)
    {
        return static::query()->where($column, $operator, $value);
    }

    public static function find($id)
    {
        return static::query()->where((new static())->primaryKey, '=', $id)->first();
    }

    public static function all()
    {
        return static::query()->get();
    }
    // relaciones 

    public function belongsTo($related, $foreignKey = null, $ownerKey = null)
    {
        $foreignKey = $foreignKey ?: $this->getForeignKey();
        $ownerKey = $ownerKey ?: 'id';

        $relatedModel = new $related;
        return $relatedModel->find($this->{$foreignKey});
    }
    public function hasOne($related, $foreignKey = null, $localKey = null)
    {
        $foreignKey = $foreignKey ?: $this->getForeignKey();
        $localKey = $localKey ?: 'id';

        $relatedModel = new $related;
        return $relatedModel->where($foreignKey, '=', $this->{$localKey})->first();
    }
    public function hasMany($related, $foreignKey = null, $localKey = null)
    {
        $foreignKey = $foreignKey ?: $this->getForeignKey();
        $localKey = $localKey ?: 'id';
        $relatedModel = new $related;
        return $relatedModel->where($foreignKey, '=', $this->{$localKey})->get();
    }
    protected function getForeignKey()
    {
        $relatedClass = get_class($this);
        $relatedClassName = class_basename($relatedClass);
        return strtolower($relatedClassName) . 'Id';
    }
}
