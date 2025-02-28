<div class="flex-grow-1 mt-5 pt-4">
    <h1 class="mb-4">Crear Nueva Cuenta</h1>
    <form action="<?= route('account.store') ?>" method="POST">
        <div class="mb-3">
            <label for="currentBalance" class="form-label">Saldo Actual</label>
            <input type="number" step="0.01" class="form-control" id="currentBalance" name="currentBalance" required>
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Tipo de Cuenta</label>
            <select class="form-select" id="type" name="type" required>
                <option value="CA">Cuenta Corriente</option>
                <option value="CC">Cuenta de Ahorros</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Estado</label>
            <select class="form-select" id="status" name="status" required>
                <option value="AC">Activa</option>
                <option value="IN">Inactiva</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="officeId" class="form-label">Oficina</label>
            <input type="number" class="form-control" id="officeId" name="officeId" required>
        </div>

        <button type="submit" class="btn btn-primary">Crear Cuenta</button>
    </form>
</div>