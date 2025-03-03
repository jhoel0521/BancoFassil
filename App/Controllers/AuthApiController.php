<?php


namespace App\Controllers;

use App\Enums\StatusCode;
use App\Models\Account;
use App\Models\Card;
use App\Models\Token;
use App\Models\Transaction;
use Core\Request;
use Core\Response;
use App\Models\User;

class AuthApiController extends ApiController
{
    public function login(Request $request): Response
    {
        try {
            $numberCard = $request->cardNumber;
            if (!isset($numberCard) || empty($numberCard)) {
                return $this->error(['message' => 'Datos incorrectos'], StatusCode::UNAUTHORIZED);
            }
            // $numberCard es numero
            if (!is_numeric($numberCard)) {
                return $this->error(['message' => 'Datos incorrectos'], StatusCode::UNAUTHORIZED);
            }
            // loega por Card por ende se debe enviar el card y el pin
            $card = Card::where("cardNumber", "=", $numberCard)->first();
            if (!isset($card)) {
                return $this->error(['message' => 'Datos incorrectos'], StatusCode::UNAUTHORIZED);
            }
            if ($card->failedAttempts >= 3) {
                return $this->error(['message' => 'Tarjeta bloqueada'], StatusCode::UNAUTHORIZED);
            }
            $pin = $request->pin;
            $cvv = $request->cvv;
            $expirationDate = $request->expirationDate;
            if (isset($pin)) {
                // verificamos que el pin sea correcto
                if (!password_verify($pin, $card->pin)) {
                    // incrementamos failedAttempts
                    $card->failedAttempts += 1;
                    $card->save();
                    return $this->error(['message' => 'Datos incorrectos'], StatusCode::UNAUTHORIZED);
                }
                $acount = $card->account;
                $person = $acount->person;
                $user = $person->user;
                $token = Token::createToken($user->id, $card->id, 'ATM', strtotime('+1 hour'));
                $card->failedAttempts = 0;
                $card->save();
                $data= $user->getAttributes();
                unset($data['password']);
                unset($data['hasCard']);
                return $this->success(['token' => $token, 'user' => ]);
            } else if (isset($cvv) && isset($expirationDate)) {
                if ($card->cvv != $cvv || $card->expirationDate != $expirationDate) {
                    $card->failedAttempts += 1;
                    $card->save();
                    return $this->error(['message' => 'Datos incorrectos'], StatusCode::UNAUTHORIZED);
                }
                if ($card->failedAttempts >= 3) {
                    return $this->error(['message' => 'Tarjeta bloqueada'], StatusCode::UNAUTHORIZED);
                }
                $card->failedAttempts = 0;
                $card->save();
                if (!$card->enabledForOnlinePurchases) {
                    return $this->error(['message' => 'Tarjeta no habilitada para compras en línea'], StatusCode::UNAUTHORIZED);
                }
                $acount = $card->account;
                $person = $acount->person;
                $user = $person->user;
                $token = Token::createToken($user->id, $card->id, 'OL', strtotime('+1 hour'));
                return $this->success(['token' => $token, 'user' => $user->getAttributes()]);
            } else {
                return $this->error(['message' => 'Datos incorrectos'], StatusCode::UNAUTHORIZED);
            }
        } catch (\Exception $e) {
            return $this->error(['message' => $e->getMessage(), 'line' => $e->getLine()], StatusCode::INTERNAL_SERVER_ERROR);
        }
    }

    public function logout(Request $request): Response
    {
        $token =  $request->token();
        $token->delete();
        return $this->success([], StatusCode::NO_CONTENT);
    }
    public function me(Request $request): Response
    {
        $data = $request->user();
        unset($data['password']);   
        unset($data['hasCard']);
        return $this->success(['user' => $data]);
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
    public function withdraw(Request $request): Response
    {
        $token = $request->token();
        // validamos que token sea de tipo ATM
        if ($token->type !== 'ATM') {
            return $this->error(['message' => 'No autorizado'], StatusCode::UNAUTHORIZED);
        }
        $account = Account::find($request->account_id);
        if (!$account) {
            return $this->error(['message' => 'Cuenta no encontrada'], StatusCode::NOT_FOUND);
        }
        // validamos que la cuenta pertenezca al usuario autenticado
        $person = $account->person;
        if ($person->id != $request->user()->personId) {
            return $this->error(['message' => 'No autorizado'], StatusCode::UNAUTHORIZED);
        }
        $amount = $request->amount;
        if ($account->currentBalance < $amount) {
            return $this->error(['message' => 'Fondos insuficientes'], StatusCode::UNPROCESSABLE_ENTITY);
        }

        $newTs = new Transaction();
        $newTs->accountId = $account->id;
        $newTs->type = 'W';
        $newTs->previousBalance = $account->currentBalance;
        $newTs->newBalance = $account->currentBalance - $amount;
        $newTs->amount = $amount;
        $newTs->commentSystem = 'Retiro ATM';
        $newTs->description = '';
        $newTs->save();
        $account->currentBalance = $newTs->newBalance;
        $account->save();

        return $this->success(['message' => 'Retiro exitoso']);
    }
    public function purchaseOnline(Request $request): Response
    {
        $token = $request->token();
        // validamos que token sea de tipo Online
        if ($token->type !== 'OL') {
            return $this->error(['message' => 'No autorizado'], StatusCode::UNAUTHORIZED);
        }
        $card = Card::find($token->cardId);
        if (!$card) {
            return $this->error(['message' => 'Tarjeta no encontrada'], StatusCode::NOT_FOUND);
        }
        // validamos que la tarjeta este habilitada para compras en línea
        if (!$card->enabledForOnlinePurchases) {
            return $this->error(['message' => 'Tarjeta no habilitada para compras en línea'], StatusCode::UNAUTHORIZED);
        }
        $account = $card->account;
        if (!$account) {
            return $this->error(['message' => 'Cuenta no encontrada'], StatusCode::NOT_FOUND);
        }
        // validamos que la cuenta pertenezca al usuario autenticado
        $person = $account->person;
        if ($person->id != $request->user()->personId) {
            return $this->error(['message' => 'No autorizado'], StatusCode::UNAUTHORIZED);
        }
        $amount = $request->amount;
        if ($account->currentBalance < $amount) {
            return $this->error(['message' => 'Fondos insuficientes'], StatusCode::UNPROCESSABLE_ENTITY);
        }

        $newTs = new Transaction();
        $newTs->accountId = $account->id;
        $newTs->type = 'P';
        $newTs->previousBalance = $account->currentBalance;
        $newTs->newBalance = $account->currentBalance - $amount;
        $newTs->amount = $amount;
        $newTs->commentSystem = 'Compra en línea';
        $newTs->description = $request->description;
        $newTs->save();
        $account->currentBalance = $newTs->newBalance;
        $account->save();

        return $this->success(['message' => 'Compra exitosa']);
    }
}
