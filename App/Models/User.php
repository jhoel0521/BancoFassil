<?php
namespace App\Models;

use Core\Model;

class User extends Model
{
    
    protected $table = 'User';
    protected $primaryKey = 'id';
    protected $fillable = ['username', 'password', 'personId', 'hasCard', 'enabledForOnlinePurchases', 'status'];
    protected $hidden = ['password'];
    protected $timestamps = false;

    public function person()
    {
        return $this->belongsTo(Person::class, 'personId', 'id');
    }
}