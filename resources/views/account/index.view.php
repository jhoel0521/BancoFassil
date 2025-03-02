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
                <th><?= $GLOBALS['translations'][$lang]['id'] ?></th>
                <th><?= $GLOBALS['translations'][$lang]['current_balance'] ?></th>
                <th><?= $GLOBALS['translations'][$lang]['account_type'] ?></th>
                <th><?= $GLOBALS['translations'][$lang]['status'] ?></th>
                <th><?= $GLOBALS['translations'][$lang]['office'] ?></th>
                <th><?= $GLOBALS['translations'][$lang]['actions'] ?></th>
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
                            <?= ($account->status === 'AC') ? $GLOBALS['translations'][$lang]['active'] : $GLOBALS['translations'][$lang]['inactive'] ?>
                        </td>
                        <td><?= htmlspecialchars($account->officeId) ?></td>
                        <td>
                            <form action="<?= route('account.destroy', ['id' => $account->id]) ?>" method="POST" class="d-inline">
                                <input type="hidden" name="_method" value="DELETE">
                                <div class="btn-group">
                                    <a href="<?= route('account.show', ['id' => $account->id]) ?>" class="btn btn-info btn-sm">
                                        <?= $GLOBALS['translations'][$lang]['view'] ?>
                                    </a>
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <?= $GLOBALS['translations'][$lang]['delete'] ?>
                                    </button>
                                </div>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center"><?= $GLOBALS['translations'][$lang]['no_accounts'] ?></td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
