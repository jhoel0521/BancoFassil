<?php

namespace App\Controllers;

use App\Enums\StatusCode;
use App\Models\Account;
use App\Models\Card;
use App\Models\Office;
use App\Models\Transaction;
use Core\Header;
use Core\PDF;
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
        return view('account.index', ['title' => traducir('Lista de Cuentas'), 'accounts' => $accounts, 'types' => $types]);
    }

    public function create()
    {
        $offices = Office::all();
        $types = Account::types();
        return view('account.create', ['title' => traducir('Crear Nueva Cuenta'), 'offices' => $offices, 'types' => $types]);
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
            Session::flash('errors', ['type' => traducir('Tipo de Cuenta no válido')]);
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

        Session::flash('success', traducir('Cuenta creada correctamente'));
        return redirect(route('account.index'));
    }

    public function show(Request $request, $accountId): Response
    {
        $account = Account::find($accountId);

        if (!$account || $account->personId !== auth()->personId) {
            return new Response(traducir('Cuenta no encontrada'), 404);
        }

        return view('account.show', [
            'account' => $account,
            'cards' => Card::where('accountId', '=', $accountId)->get(),
            'transactions' => Transaction::where('accountId', '=', $accountId)
                ->orderBy('created_at', 'DESC')
                ->limit(5)
                ->get(),
            'title' => traducir('Cuenta')
        ]);
    }

    public function transfer(Request $request, $accountId): Response
    {
        $account = Account::find($accountId);
        if (!$account || $account->personId !== auth()->personId) {
            return  Response::json(['errors' => ['general' => traducir('Cuenta no encontrada')]], StatusCode::NOT_FOUND);
        }

        $validator = new Validation();
        $rules = [
            'amount' => 'required|number|min:0.01|max:99999999.99',
            'type' => 'required|string|in:D,W',
            'description' => 'string|max:255'
        ];

        if (!$validator->validate($_POST, $rules)) {
            Session::flash('errors', $validator->errors());
            return Response::json(['errors' => $validator->errors()], StatusCode::BAD_REQUEST);
        }

        $amount = $_POST['amount'];
        $type = $_POST['type'];

        if ($type === 'W') {
            // Validar que tenga saldo suficiente
            if ($account->currentBalance < $amount) {
                Session::flash('errors', ['amount' => traducir('Saldo insuficiente')]);
                return Response::json(['errors' => ['amount' => traducir('Saldo insuficiente')]], StatusCode::BAD_REQUEST);
            }
        }
        if ($type === 'D') {
            $amountLimit = number_format($amount + $account->currentBalance, 2, '.', '');
            if ($amountLimit > 99999999.99) {
                Session::flash('errors', ['amount' => traducir('El monto supera el límite permitido')]);
                return Response::json(['errors' => ['amount' => traducir('El monto supera el límite permitido')]], StatusCode::BAD_REQUEST);
            }
        }

        $tf = new Transaction();
        $tf->type = $type;
        $tf->previousBalance = $account->currentBalance;
        $tf->newBalance = $type === 'D' ? $account->currentBalance + $amount : $account->currentBalance - $amount;
        $tf->amount = $amount;
        $tf->commentSystem = $type === 'D' ? 'Deposito' : 'Retiro';
        $tf->description = $_POST['description'];
        $tf->accountId = $accountId;
        $tf->save();

        $account->currentBalance = $type === 'D' ? $account->currentBalance + $amount : $account->currentBalance - $amount;
        $account->save();

        Session::flash('success', traducir('Transferencia realizada correctamente'));
        return Response::json(['success' => traducir('Transferencia realizada correctamente')], StatusCode::CREATED);
    }

    public function createCard(Request $request, $accountId): Response
    {
        $account = Account::find($accountId);
        if (!$account || $account->personId !== auth()->personId) {
            return Response::json(['errors' => ['general' => traducir('Cuenta no encontrada')]], StatusCode::NOT_FOUND);
        }

        $validator = new Validation();
        $rules = [
            'pin' => 'required|numeric|min:4|max:4',
            'cardType' => 'required|string|max:1|in:D',
        ];

        if (!$validator->validate($request->all(), $rules)) {
            Session::flash('errors', $validator->errors());
            return Response::json(['errors' => $validator->errors()], StatusCode::BAD_REQUEST);
        }
        $account->hasCard = true;
        $account->save();
        $card = new Card();
        $card->cardNumber = Card::generateCardNumber();
        $expirationDate = date('Y-m', strtotime('+4 years'));
        $card->expirationDate = substr($expirationDate, 2);
        $card->cvv = Card::generateCVV();
        $card->pin = password_hash($_POST['pin'], PASSWORD_DEFAULT);
        $card->enabledForOnlinePurchases = 1;
        $card->accountId = $accountId;
        $card->save();

        Session::flash('success', traducir('Tarjeta creada correctamente'));
        return Response::json(['success' => traducir('Tarjeta creada correctamente')], StatusCode::CREATED);
    }
    public function purchaseOnline(Request $request, $idAccont, $idCard)
    {
        $card = Card::find($idCard);
        if (!$card || $card->accountId !== $idAccont) {
            return new Response(traducir('Tarjeta no encontrada'), 404);
        }
        $card->enabledForOnlinePurchases = $card->enabledForOnlinePurchases ? 0 : 1;
        $card->save();
        Session::flash('success', traducir('Tarjeta actualizada correctamente'));
        return redirect(route('account.show', ['id' => $idAccont]));
    }
    public function report(Request $request, $id)
    {
        $account = Account::where('id', '=', $id)->first();
        if (!isset($account) || $account->personId !== auth()->personId) {
            return view('errors.404', ['title' => '404']);
        }
        $header = new Header(
            traducir('transaction_history'),
            traducir('account') . ' N° ' . str_pad($id, 8, '0', STR_PAD_LEFT),
            date('d/m/Y H:i')
        );
        $pdf = new PDF($header);
        $pdf->SetTitle(utf8_decode(traducir('transaction_history')));
        $pdf->AliasNbPages();

        // Configurar contenido del PDF
        $pdf->AddPage();
        $pdf->Ln(10);
        $from = $request->input('from', null);
        $to = $request->input('to', null);
        if (isset($from) && isset($to) && $from != '' && $to != '') {
            $transactions = Transaction::where('accountId', '=', $id)
                ->whereBetween('DATE(created_at)', [$from, $to])
                ->orderBy('created_at', 'DESC')
                ->get();
            $isAll = false;
        } else {
            $transactions = Transaction::where('accountId', '=', $id)
                ->orderBy('created_at', 'DESC')
                ->get();
            $isAll = true;
        }
        $this->generateAccountReport($account, $transactions, $pdf, $isAll, $from, $to);
        $pdf->Output('I', 'reporte_cuenta_' . $id . '.pdf');
        exit;
    }

    public function allReports(Request $request)
    {
        $from = $request->input('from', null);
        $to = $request->input('to', null);
        if (isset($from) && isset($to) && $from != '' && $to != '') {
            $transactions = Transaction::query()
                ->whereBetween('DATE(created_at)', [$from, $to])
                ->orderBy('created_at', 'DESC')
                ->get();
            $isAll = false;
        } else {
            $transactions = Transaction::query()
                ->orderBy('created_at', 'DESC')
                ->get();
            $isAll = true;
        }
        $idAccounts = [];
        foreach ($transactions as $transaction) {
            if (!in_array($transaction->accountId, $idAccounts)) {
                $idAccounts[] = $transaction->accountId;
            }
        }
        $accounts = Account::whereIn('id', $idAccounts)->get();
        $header = new Header(
            traducir('all_accounts_report'),
            traducir('generated_report'),
            date('d/m/Y H:i')
        );
        $pdf = new PDF($header);
        $pdf->SetTitle(traducir('all_accounts_report'));
        $pdf->AliasNbPages();



        foreach ($accounts as $account) {
            // Agregar sección por cada cuenta
            $pdf->AddPage();
            $pdf->Ln(10);
            if ($isAll) {
                $transactions = Transaction::where('accountId', '=', $account->id)
                    ->orderBy('created_at', 'DESC')
                    ->get();
            } else {
                $transactions = Transaction::where('accountId', '=', $account->id)
                    ->whereBetween('DATE(created_at)', [$from, $to])
                    ->orderBy('created_at', 'DESC')
                    ->get();
            }
            $this->generateAccountReport($account, $transactions, $pdf, $isAll, $from, $to);
        }

        $pdf->Output('I', 'reporte_general.pdf');
        exit;
    }
    // En AccountController.php o en un servicio externo
    /**
     * Summary of generateAccountReport
     * @param \App\Models\Account $account
     * @param \App\Models\Transaction[] $transactions
     * @param \Core\PDF $pdf
     * @param bool $isAll
     * @return void
     */
    protected function generateAccountReport(Account $account, array $transactions, PDF $pdf, bool $isAll = true, $from = null, $to = null): void
    {
        // Encabezado de la cuenta
        $pdf->setLetterTitle(0, 0, 0, 'B');
        $pdf->Cell(0, 10, traducir('Cuenta N° ') . str_pad($account->id, 8, '0', STR_PAD_LEFT), 0, 1);

        $pdf->setLetterNormal(0, 0, 0);
        $pdf->Cell(0, 7, traducir('Saldo actual: ') . number_format($account->currentBalance, 2), 0, 1);
        $pdf->Cell(0, 7, traducir('Cliente: ') . $account->person->name, 0, 1);
        $pdf->Cell(0, 7, traducir('Fecha de apertura: ') . $account->created_at, 0, 1);
        if (!$isAll) {
            $pdf->Cell(0, 7, traducir('Desde: ') . $from . ' ' . traducir('Hasta: ') . $to, 0, 1);
        } else {
            $pdf->Cell(0, 7, traducir('Todo el historial'), 0, 1);
        }

        // Espacio antes de la tabla
        $pdf->Ln(10);

        // Encabezados de la tabla
        $pdf->setTitleStyle(true);
        $pdf->Cell(20, 10, traducir('Tipo'), 1, 0, 'C', true);
        $pdf->Cell(50, 10, traducir('Descripción'), 1, 0, 'C', true);
        $pdf->Cell(35, 10, traducir('Fecha y Hora'), 1, 0, 'C', true);
        $pdf->Cell(30, 10, traducir('Saldo Anterior'), 1, 0, 'C', true);
        $pdf->Cell(30, 10, traducir('Monto'), 1, 0, 'C', true);
        $pdf->Cell(30, 10, traducir('Saldo Nuevo'), 1, 1, 'C', true);

        // Contenido de transacciones
        $pdf->setTitleStyle(false);
        $fill = false;
        $totalDepositos = 0;
        $totalRetiros = 0;

        foreach ($transactions as $transaction) {
            // Alternar color de fondo
            $fill = !$fill;
            $pdf->SetFillColor($fill ? 240 : 255);

            // Determinar tipo y color
            $tipo = $transaction->type == 'DEPOSITO' ? 'Depósito' : 'Retiro';
            $color = $transaction->type == 'DEPOSITO' ? [0, 100, 0] : [139, 0, 0];

            $pdf->setLetterNormal($color[0], $color[1], $color[2]);

            // Celdas
            $pdf->Cell(20, 8, $tipo, 1, 0, 'C', $fill);
            $pdf->Cell(50, 8, substr($transaction->description, 0, 30), 1, 0, 'L', $fill);
            $pdf->Cell(35, 8, $transaction->created_at, 1, 0, 'C', $fill);
            $pdf->Cell(30, 8, number_format($transaction->previousBalance, 2), 1, 0, 'R', $fill);
            $pdf->Cell(30, 8, number_format($transaction->amount, 2), 1, 0, 'R', $fill);
            $pdf->Cell(30, 8, number_format($transaction->newBalance, 2), 1, 1, 'R', $fill);

            // Calcular totales
            if ($transaction->type == 'DEPOSITO') {
                $totalDepositos += $transaction->amount;
            } else {
                $totalRetiros += $transaction->amount;
            }
        }

        // Línea de totales
        $pdf->setLetterNormal(0, 0, 0, 'B');
        $pdf->SetFillColor(255, 255, 255);
        $pdf->Cell(135, 8, 'TOTALES:', 1, 0, 'R', true);
        $pdf->Cell(30, 8, number_format($totalDepositos, 2), 1, 0, 'R', true);
        $pdf->Cell(30, 8, number_format($totalRetiros, 2), 1, 1, 'R', true);
    }
}
