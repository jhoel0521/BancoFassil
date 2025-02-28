<?php

namespace App\Models;

use Core\Model;

class Card extends Model
{
    protected $table = 'Card';
    protected $primaryKey = 'id';
    protected $fillable = [
        'cardNumber',
        'expirationDate',
        'cardType',
        'cvv',
        'pin',
        'accountId',
        'failedAttempts',
    ];
    protected $timestamps = false;

    /**
     * Relación con la tabla Account.
     */
    public function account()
    {
        return $this->belongsTo(Account::class, 'accountId', 'id');
    }
}