<?php

namespace App\Models;

use Core\Model;

class Token extends Model
{
    protected $table = 'Token';
    protected $primaryKey = 'id';
    protected $fillable = ['token', 'type', 'expirationDate', 'userId', 'cardId'];
    protected $timestamps = true;


    /**
     * Crea un nuevo token para el usuario.
     *
     * @param int $userId
     * @param string $type
     * @return string
     */
    public static function createToken(int $userId, int $cardId, string $type = 'OL', $limit = null): string
    {
        // Generar un token único
        $token = bin2hex(random_bytes(32));

        $expirationDate = date('Y-m-d H:i:s', $limit ?? strtotime('+1 hour'));

        $instacia = new Token();
        $instacia->userId = $userId;
        $instacia->type = $type;
        $instacia->expirationDate = $expirationDate;
        $instacia->token = $token;
        $instacia->cardId = $cardId;
        $instacia->save();
        return $token;
    }

    /**
     * Verifica si un token es válido.
     *
     * @param string $token
     * @return bool
     */
    public static function isValid(string $token): bool
    {
        $token = Token::where('token', '=', $token)->where('expirationDate', '>', date('Y-m-d H:i:s'))
            ->first();

        return $token !== null;
    }

    /**
     * Obtiene el usuario asociado a un token.
     *
     * @param string $token
     * @return User|null
     */
    public static function getUserByToken(string $token): ?User
    {
        $token = Token::where('token', '=', $token)
            ->where('expirationDate', '>', date('Y-m-d H:i:s'))
            ->first();
        if ($token) {
            return User::find($token->userId);
        }

        return null;
    }
    public function card()
    {
        return $this->belongsTo(Card::class, 'cardId');
    }
}
