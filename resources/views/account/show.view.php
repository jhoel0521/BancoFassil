<!-- show/account.view.php -->
<div class="container mt-5">
    <!-- Encabezado con saldo actual -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">
            <i class="bi bi-wallet2 me-2"></i>Cuenta #<?= $account->accountNumber ?>
        </h1>
        <div class="d-flex align-items-center bg-primary text-white p-3 rounded-3">
            <i class="bi bi-cash-coin fs-3 me-2"></i>
            <div>
                <span class="small d-block">Saldo actual</span>
                <h3 class="mb-0">$<?= number_format($account->currentBalance, 2) ?></h3>
            </div>
        </div>
    </div>

    <!-- Sección de acciones rápidas -->
    <div class="d-grid gap-3 d-md-flex justify-content-md-end mb-4">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCardModal">
            <i class="bi bi-credit-card me-2"></i>Agregar Tarjeta
        </button>
        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#transferModal">
            <i class="bi bi-arrow-left-right me-2"></i>Realizar Movimiento
        </button>
    </div>

    <!-- Últimas transacciones -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Últimos movimientos</h5>
        </div>
        <div class="card-body p-0">
            <div class="list-group list-group-flush">
                <?php if (!empty($transactions)): ?>
                    <?php foreach ($transactions as $transaction): ?>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <?php if ($transaction->type === 'D'): ?>
                                    <i class="bi bi-arrow-down-circle text-success fs-4 me-3"></i>
                                <?php else: ?>
                                    <i class="bi bi-arrow-up-circle text-danger fs-4 me-3"></i>
                                <?php endif; ?>
                                <span class="fw-bold"><?= $transaction->description ?></span>
                                <div class="text-muted small"><?= $transaction->created_at ?></div>
                            </div>
                            <div class="text-end">
                                <div class="<?= $transaction->type === 'D' ? 'text-success' : 'text-danger' ?>">
                                    $<?= number_format($transaction->amount, 2) ?>
                                </div>
                                <div class="text-muted small">
                                    Saldo: $<?= number_format($transaction->newBalance, 2) ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="list-group-item text-center text-muted py-4">
                        No hay movimientos registrados
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Tarjetas asociadas -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="bi bi-credit-card-2-front me-2"></i>Tarjetas asociadas</h5>
        </div>
        <div class="card-body">
            <?php if (empty($cards)): ?>
                <div class="text-center text-muted py-4">
                    <i class="bi bi-credit-card-2-back fs-1 text-muted"></i>
                    <p class="mt-3">No tienes tarjetas asociadas</p>
                </div>
            <?php else: ?>
                <div class="row">
                    <?php foreach ($cards as $card): ?>
                        <div class="col-md-6 col-xl-4 mb-4">
                            <div class="card border-<?= $card->cardType === 'D' ? 'primary' : 'warning' ?>">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="card-title mb-0">
                                            <i class="bi bi-credit-card-2-front me-2"></i>
                                            <?= $card->cardType === 'D' ? 'Débito' : 'Crédito' ?>
                                        </h5>
                                        <i class="bi bi-<?= $card->cardType === 'D' ? 'safe' : 'cash-coin' ?> fs-4"></i>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <div class="text-muted small">Número de tarjeta</div>
                                        <div class="fw-bold">•••• •••• •••• <?= substr($card->cardNumber, -4) ?></div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="text-muted small">CVV</div>
                                            <div class="d-flex align-items-center">
                                                <span class="cvv me-2">•••</span>
                                                <button class="btn btn-sm btn-outline-secondary toggle-cvv">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-muted small">PIN</div>
                                            <div class="d-flex align-items-center">
                                                <span class="pin me-2">••••</span>
                                                <button class="btn btn-sm btn-outline-secondary toggle-pin">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-3 text-muted small">
                                        <i class="bi bi-calendar-check me-1"></i>
                                        Expira: <?= $card->expirationDate ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal para Transferencias -->
    <div class="modal fade" id="transferModal" tabindex="-1" aria-labelledby="transferModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="transferModalLabel">
                        <i class="bi bi-arrow-left-right me-2"></i>Realizar Movimiento
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?= route('account.transfer', ['id' => $account->id]) ?>" method="POST">
                        <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                        <div class="mb-3">
                            <label for="amount" class="form-label">
                                <i class="bi bi-cash-coin me-1"></i>Monto
                            </label>
                            <input type="number" class="form-control" id="amount" name="amount" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-arrow-repeat me-1"></i>Tipo de Movimiento
                            </label>
                            <div class="d-flex gap-3">
                                <div class="form-check flex-grow-1">
                                    <input class="form-check-input" type="radio" name="type" id="deposit" value="D" checked>
                                    <label class="form-check-label w-100 p-3 bg-success bg-opacity-10 rounded" for="deposit">
                                        <i class="bi bi-arrow-down-circle fs-4 text-success me-2"></i>
                                        <span class="d-block fw-bold">Depósito</span>
                                        <small class="text-muted">Añadir fondos a la cuenta</small>
                                    </label>
                                </div>
                                <div class="form-check flex-grow-1">
                                    <input class="form-check-input" type="radio" name="type" id="withdraw" value="W">
                                    <label class="form-check-label w-100 p-3 bg-danger bg-opacity-10 rounded" for="withdraw">
                                        <i class="bi bi-arrow-up-circle fs-4 text-danger me-2"></i>
                                        <span class="d-block fw-bold">Retiro</span>
                                        <small class="text-muted">Retirar fondos de la cuenta</small>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>Confirmar Movimiento
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Crear Tarjetas -->
    <div class="modal fade" id="createCardModal" tabindex="-1" aria-labelledby="createCardModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createCardModalLabel">
                        <i class="bi bi-credit-card me-2"></i>Crear Tarjeta
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?= route('card.create', ['id' => $account->id]) ?>" method="POST">
                        <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                        <div class="mb-3">
                            <label for="cardType" class="form-label">
                                <i class="bi bi-card-heading me-1"></i>Tipo de Tarjeta
                            </label>
                            <select class="form-select" id="cardType" name="cardType" required>
                                <option value="D">Débito</option>
                                <option value="C">Crédito</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="pin" class="form-label">
                                <i class="bi bi-lock me-1"></i>PIN
                            </label>
                            <input type="password" class="form-control" id="pin" name="pin" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>Crear Tarjeta
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts actualizados con iconos -->
<script>
    document.querySelectorAll('.toggle-cvv').forEach(button => {
        button.addEventListener('click', () => {
            const icon = button.querySelector('i');
            const cvvSpan = button.previousElementSibling;
            if (cvvSpan.textContent === '•••') {
                cvvSpan.textContent = '<?= $card->cvv ?>';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                cvvSpan.textContent = '•••';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });
    });

    document.querySelectorAll('.toggle-pin').forEach(button => {
        button.addEventListener('click', () => {
            const icon = button.querySelector('i');
            const pinSpan = button.previousElementSibling;
            if (pinSpan.textContent === '••••') {
                pinSpan.textContent = '<?= $card->pin ?>';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                pinSpan.textContent = '••••';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });
    });
</script>