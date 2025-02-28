<?php

namespace App\Controllers;

use App\Models\Account;
use App\Models\Office;

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
        dd($Offices);
        return view('account.create', ['title' => 'Crear Nueva Cuenta']);
    }
}
