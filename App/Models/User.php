<?php
namespace App\Models;

use Core\Model;

class User extends Model
{
    public $username;
    public $password;
    public $personId;
    public $hasCard;
    public $enabledForOnlinePurchases;
    public $status;
    
    protected $table = 'User';
    protected $primaryKey = 'id';
    protected $fillable = ['username', 'password', 'personId', 'hasCard', 'enabledForOnlinePurchases', 'status'];
    protected $hidden = ['password'];
    protected $timestamps = false;

    public function person()
    {
        return Person::find($this->personId);
    }
}