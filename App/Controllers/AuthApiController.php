<?php


namespace App\Controllers;

use App\Enums\StatusCode;
use App\Models\Card;
use App\Models\Token;
use Core\Request;
use Core\Response;
use App\Models\User;

class AuthApiController extends ApiController
{
    public function login(Request $request): Response
    {
        try {
            // loega por Card por ende se debe enviar el card y el pin
            $card = Card::where("cardNumber", "=", $request->cardNumber)->first();
            if (!isset($card)) {
                return $this->error(['message' => 'Datos incorrectos'], StatusCode::UNAUTHORIZED);
            }
            if ($card->failedAttempts >= 3) {
                return $this->error(['message' => 'Tarjeta bloqueada'], StatusCode::UNAUTHORIZED);
            }
            // verificamos que el pin sea correcto
            if (!password_verify($request->pin, $card->pin)) {
                // incrementamos failedAttempts
                $card->failedAttempts += 1;
                $card->save();
                return $this->error(['message' => 'Datos incorrectos'], StatusCode::UNAUTHORIZED);
            }
            $acount = $card->account;
            $person = $acount->person;
            $user = $person->user;
            $token = Token::createToken($user->id, 'ATM', strtotime('+1 hour'));
            $card->failedAttempts = 0;
            $card->save();
            return $this->success(['token' => $token, 'user' => $user->getAttributes()]);
        } catch (\Exception $e) {
            return $this->error(['message' => $e->getMessage(), 'line' => $e->getLine()], StatusCode::INTERNAL_SERVER_ERROR);
        }
    }

    public function logout(Request $request): Response
    {
        $token = $request->header('Authorization');
        Token::revokeToken($token);
        return $this->success([], StatusCode::NO_CONTENT);
    }
    public function me(Request $request): Response
    {
        return $this->success(['user' => $request->user()->getAttributes()]);
    }
    public function accounts(Request $request): Response
    {
        $user = $request->user();
        $accounts = $user->person->accounts;
        $result = [];
        foreach ($accounts as $account) {
            $result[] = $account->getAttributes();
        }
        return $this->success(['accounts' => $result]);
    }
}
