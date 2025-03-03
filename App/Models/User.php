<?php

namespace App\Models;

use Core\Model;

class User extends Model
{

    protected $table = 'User';
    protected $primaryKey = 'id';
    protected $fillable = ['username', 'password', 'personId', 'hasCard', 'status'];
    protected $hidden = ['password'];
    protected $timestamps = false;

    public function person()
    {
        return $this->belongsTo(Person::class, 'personId', 'id');
    }
    public function createToken(): string
    {
        return Token::createToken($this->id);
    }
    /**
     * Revoca todos los tokens del usuario.
     *
     * @return bool
     */

    public function tokens()
    {
        return $this->hasMany(Token::class, 'userId', 'id');
    }
}
