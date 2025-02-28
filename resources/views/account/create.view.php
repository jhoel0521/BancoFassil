<div class="container mt-5">
    <style>
        .form-label {
            font-weight: 500;
            color: #003366;
        }

        .card-header {
            background: linear-gradient(135deg, #003366, #004080);
        }

        .select2-container--default .select2-selection--single {
            border-color: #dee2e6;
            height: 38px;
            padding: 5px;
        }
    </style>
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0">
                        <i class="bi bi-plus-circle me-2"></i>
                        Crear Nueva Cuenta
                    </h3>
                </div>

                <div class="card-body">
                    <?php if (!empty($success)): ?>
                        <div class="alert alert-success"><?= $success ?></div>
                    <?php endif; ?>

                    <form action="<?= route('account.store') ?>" method="POST">
                        <input type="hidden" name="_token" value="<?= csrf_token() ?>">

                        <!-- Tipo de Cuenta -->
                        <div class="mb-3">
                            <label class="form-label">Tipo de Cuenta</label>
                            <select class="form-select <?= isset($errors['type']) ? 'is-invalid' : '' ?>"
                                name="type">
                                <option value="">Seleccione un tipo de cuenta</option>
                                <?php foreach ($types as $key => $value): ?>
                                    <option value="<?= $key ?>"><?= $value ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (isset($errors['type'])):
                                foreach ($errors['type'] as $error): ?>
                                    <div class="invalid-feedback"><?= $error ?></div>
                            <?php
                                endforeach;
                            endif; ?>
                        </div>

                        <!-- Oficina Asociada -->
                        <div class="mb-3">
                            <label class="form-label">Oficina Asociada</label>
                            <select class="form-select <?= isset($errors['officeId']) ? 'is-invalid' : '' ?>"
                                name="officeId">
                                <option value="">Seleccione una oficina</option>
                                <?php foreach ($offices as $office): ?>
                                    <option value="<?= $office->id ?>"><?= $office->name ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (isset($errors['officeId'])):
                                foreach ($errors['officeId'] as $error): ?>
                                    <div class="invalid-feedback"><?= $error ?></div>
                            <?php
                                endforeach;
                            endif; ?>
                        </div>

                        <!-- Botón de Envío -->
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-save me-2"></i> Crear Cuenta
                        </button>
                    </form>
                </div>

                <div class="card-footer text-center">
                    <a href="<?= route('account.index') ?>" class="text-decoration-none">
                        Volver a la lista de cuentas
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>