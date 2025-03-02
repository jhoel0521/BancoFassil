<?php
// Cargar el idioma desde el archivo de configuraciones
require_once 'langs/translations.php'; // Ajusta la ruta si es necesario

// Asignar el idioma de la sesión o establecer uno por defecto
$lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'es'; // o 'en', según lo que elijas
?>
<div class="flex-grow-1 mt-5 pt-4">
    <h1 class="mb-4"><?= $GLOBALS['translations'][$lang]['account_list'] ?></h1>
    <a href="<?= route('account.create') ?>" class="btn btn-primary mb-4">
        <?= $GLOBALS['translations'][$lang]['create_account'] ?>
    </a>

    <table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th><?= traducir('id') ?></th>
            <th><?= traducir('current_balance') ?></th>
            <th><?= traducir('account_type') ?></th>
            <th><?= traducir('status') ?></th>
            <th><?= traducir('office') ?></th>
            <th><?= traducir('actions') ?></th>
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
                        <?= ($account->status === 'AC') ? traducir('active') : traducir('inactive') ?>
                    </td>
                    <td><?= htmlspecialchars($account->officeId) ?></td>
                    <td>
                        <form action="<?= route('account.destroy', ['id' => $account->id]) ?>" method="POST" class="d-inline">
                            <input type="hidden" name="_method" value="DELETE">
                            <div class="btn-group">
                                <a href="<?= route('account.show', ['id' => $account->id]) ?>" class="btn btn-info btn-sm">
                                    <?= traducir('view') ?>
                                </a>
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <?= traducir('delete') ?>
                                </button>
                            </div>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" class="text-center"><?= traducir('no_accounts') ?></td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
