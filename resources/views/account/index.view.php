<div class="flex-grow-1 mt-5 pt-4">
    <h1 class="mb-4">Lista de Cuentas</h1>
    <a href="<?= route('account.create') ?>" class="btn btn-primary mb-4">
        Crear Nueva Cuenta
    </a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Saldo Actual</th>
                <th>Tipo de Cuenta</th>
                <th>Estado</th>
                <th>Oficina</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($accounts)): ?>
                <?php foreach ($accounts as $account): ?>
                    <tr>
                        <td><?= htmlspecialchars($account->id) ?></td>
                        <td><?= htmlspecialchars($account->currentBalance) ?></td>
                        <td>
                            <?= $types[$account->type] ?>
                        </td>
                        <td>
                            <?= ($account->status === 'AC') ? 'Activa' : 'Inactiva' ?>
                        </td>
                        <td><?= htmlspecialchars($account->officeId) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">No hay cuentas registradas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>