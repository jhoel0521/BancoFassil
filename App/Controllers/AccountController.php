<?php

namespace App\Controllers;

use App\Models\Account;
use App\Models\Office;
use Core\Validation;
use Core\Session;

class AccountController extends Controller
{
    public function index()
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
    public function store()
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
}
