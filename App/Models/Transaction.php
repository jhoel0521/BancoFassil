<?php

namespace App\Models;

use Core\Model;

class Transaction extends Model
{
    protected $table = 'Transaction';
    protected $primaryKey = 'id';
    protected $fillable = [
        'type',
        'previousBalance',
        'newBalance',
        'amount',
        'commentSystem',
        'description',
        'accountId',
    ];
    protected $timestamps = true;

    /**
     * Relación con la tabla Account.
     */
    public function account()
    {
        return $this->belongsTo(Account::class, 'accountId', 'id');
    }
}
