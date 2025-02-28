<?php
namespace App\Models;

use Core\Model;
class Person extends Model
{
    protected $table = 'Person';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'email', 'phone'];
    protected $timestamps = false;
}