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

    public static function generateCardNumber(): string
    {
        $cardNumber = '';
        for ($i = 0; $i < 16; $i++) {
            $cardNumber .= rand(0, 9);
        }
        // validar que el número de tarjeta no exista en la base de datos
        $cardNumber = self::where('cardNumber', '=', $cardNumber)->first() ? self::generateCardNumber() : $cardNumber;
        return $cardNumber;
    }
    public static function generateCVV(): string
    {
        $pin = '';
        for ($i = 0; $i < 3; $i++) {
            $pin .= rand(0, 9);
        }
        return $pin;
    }
}
