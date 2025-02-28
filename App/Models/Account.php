<?php

namespace App\Models;

use Core\Model;

class Account extends Model
{

    protected $table = 'Account';
    protected $primaryKey = 'id';
    protected $fillable = ['currentBalance', 'type', 'status', 'personId', 'officeId'];
    protected $timestamps = true;
    public static function types()
    {
        if (getLanguage() == 'es') {
            return [
                'CA' => 'Cuenta Corriente',
                'CC' => 'Cuenta de Ahorro'
            ];
        } elseif (getLanguage() == 'en') {
            return [
                'CA' => 'Current Account',
                'CC' => 'Savings Account'
            ];
        }
    }
}
