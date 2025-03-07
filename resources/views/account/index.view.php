<div class="flex-grow-1 mt-5 pt-4">
    <h1 class="mb-4"><?= traducir('account_list') ?></h1>
    <div class="d-flex gap-2 mb-4">
        <a href="<?= route('account.create') ?>" class="btn btn-primary mb-4">
            <?= traducir('create_account') ?>
        </a>
        <button class="btn btn-success mb-4"><i class="bi bi-file-pdf-fill"></i> <?= traducir('report_all_accounts') ?></button>
    </div>

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
                        <td><?= $account->office->name ?></td>
                        <td>

                            <div class="btn-group">
                                <a href="<?= route('account.show', ['id' => $account->id]) ?>" class="btn btn-info btn-sm">
                                    <?= traducir('view') ?>
                                </a>
                            </div>
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

    <!-- Modal Reporte Individual -->
    <div class="modal fade" id="reportModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?= traducir('generate_report') ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="reportForm" method="GET">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label"><?= traducir('report_format') ?></label>
                            <select class="form-select" name="format">
                                <option value="pdf">PDF</option>
                                <option value="excel">Excel</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= traducir('cancel') ?></button>
                        <button type="submit" class="btn btn-primary"><?= traducir('generate') ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Configurar formulario individual
            const reportModal = document.getElementById('reportModal');
            const reportForm = document.getElementById('reportForm');

            reportModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const accountId = button.getAttribute('data-account-id');
                reportForm.action = `/account/${accountId}/report`;
            });
        });
    </script>