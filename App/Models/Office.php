<?php
namespace App\Models;

use Core\Model;

class Office extends Model
{
    protected $table = 'Office';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'address', 'type'];
    protected $timestamps = false;
    
}