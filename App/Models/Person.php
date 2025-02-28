<?php

namespace App\Models;

use Core\Model;

class Person extends Model
{
    protected $table = 'Person';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'email', 'phone'];
    protected $timestamps = false;
    public function user()
    {
        return $this->hasOne(User::class, 'personId', 'id');
    }
    // una persona tiene muchas Account
    public function accounts()
    {
        return $this->hasMany(Account::class, 'personId', 'id');
    }
}
