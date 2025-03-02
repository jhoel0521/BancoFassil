<?php

namespace App\Controllers;

use App\Models\Account;
use App\Models\Card;
use App\Models\Office;
use App\Models\Transaction;
use Core\Request;
use Core\Response;
use Core\Validation;
use Core\Session;


class AccountController extends Controller
{
    public function index(): Response
    {
        $user = auth();
        $accounts = $user->person->accounts;
        $types = Account::types();
        return view('account.index', ['title' => 'Lista Cuentas', 'accounts' => $accounts, 'types' => $types]);
    }
    public function create()
    {
        $Offices = Office::all();
        $types = Account::types();
        return view('account.create', ['title' => 'Crear Nueva Cuenta', 'offices' => $Offices, 'types' => $types]);
    }
    public function store(): Response
    {

        $validator = new Validation();
        $rules = [
            'type' => 'required|string|max:2',
            'officeId' => 'required|numeric'
        ];
        if (!$validator->validate($_POST, $rules)) {
            Session::flash('errors', $validator->errors());
            Session::flash('old', $_POST);
            return redirect(route('account.create'));
        }
        if (!array_key_exists($_POST['type'], Account::types())) {
            Session::flash('errors', ['type' => 'Tipo de cuenta no válido']);
            Session::flash('old', $_POST);
            return redirect(route('account.create'));
        }
        $account = new Account();
        $account->type = $_POST['type'];
        $account->officeId = $_POST['officeId'];
        $account->personId = auth()->person->id;
        $account->status = 'AC';
        $account->currentBalance = 0;
        $account->save();
        Session::flash('success', 'Cuenta creada correctamente');
        return redirect(route('account.index'));
    }
    public function show(Request $request, $accountId): Response
    {
        $account = Account::find($accountId);

        if (!$account || $account->personId !== auth()->personId) {
            return new Response('Cuenta no encontrada', 404);
        }

        return view('account.show', [
            'account' => $account,
            'cards' => Card::where('accountId', '=', $accountId)->get(),
            'transactions' => Transaction::where('accountId', '=', $accountId)
                ->orderBy('created_at', 'DESC')
                ->limit(5)
                ->get()
        ]);
    }
    public function transfer(Request $request, $accountId): Response
    {
        $account = Account::find($accountId);
        if (!$account || $account->personId !== auth()->personId) {
            return new Response('Cuenta no encontrada', 404);
        }
        $validator = new Validation();
        $rules = [
            'amount' => 'required|numeric|min:1',
            'type' => 'required|string|in:D,W'
        ];
        if (!$validator->validate($_POST, $rules)) {
            Session::flash('errors', $validator->errors());
            return redirect(route('account.show', ['id' => $accountId]));
        }
        $amount = $_POST['amount'];
        $type = $_POST['type'];
        if ($type === 'W') {
            // validar que tenga saldo suficiente
            if ($account->currentBalance <= $amount) {
                Session::flash('errors', ['amount' => 'Saldo insuficiente']);
                return redirect(route('account.show', ['id' => $accountId]));
            }
        }
        $tf = new Transaction();
        $tf->type = $type;
        $tf->previousBalance = $account->currentBalance;
        $tf->newBalance = $type === 'D' ? $account->currentBalance + $amount : $account->currentBalance - $amount;
        $tf->amount = $amount;
        $tf->commentSystem = 'Transferencia';
        $tf->description = 'Transferencia de fondos';
        $tf->accountId = $accountId;
        $tf->save();
        if ($type === 'W' && $account->currentBalance < $amount) {
            Session::flash('errors', ['amount' => 'Saldo insuficiente']);
            return redirect(route('account.show', ['id' => $accountId]));
        }
        $account->currentBalance = $type === 'D' ? $account->currentBalance + $amount : $account->currentBalance - $amount;
        $account->save();
        Session::flash('success', 'Transferencia realizada correctamente');
        return redirect(route('account.show', ['id' => $accountId]));
    }
    public function createCard(Request $request, $accountId): Response
    {
        $account = Account::find($accountId);
        if (!$account || $account->personId !== auth()->personId) {
            return new Response('Cuenta no encontrada', 404);
        }
        $validator = new Validation();
        $rules = [
            'pin' => 'required|numeric|min:4|max:4',
            'cardType' => 'required|string|max:1|in:D',
        ];
        if (!$validator->validate($_POST, $rules)) {
            Session::flash('errors', $validator->errors());
            return redirect(route('account.show', ['id' => $accountId]));
        }
        $card = new Card();
        $card->cardNumber = Card::generateCardNumber();
        $expirationDate = date('Y-m', strtotime('+4 years'));
        $card->expirationDate = substr($expirationDate, 2);
        $card->cvv = Card::generateCVV();
        $card->pin = password_hash($_POST['pin'], PASSWORD_DEFAULT);
        $card->accountId = $accountId;
        //dd($card);
        $card->save();
        Session::flash('success', 'Tarjeta creada correctamente');
        return redirect(route('account.show', ['id' => $accountId]));
    }
}
