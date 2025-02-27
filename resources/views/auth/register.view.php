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
                        <i class="bi bi-person-plus me-2"></i>Registro de Cliente
                    </h3>
                </div>

                <div class="card-body">
                    <?php if (!empty($success)): ?>
                        <div class="alert alert-success"><?= $success ?></div>
                    <?php endif; ?>

                    <form action="<?= route('auth.register') ?>" method="POST">
                        <input type="hidden" name="_token" value="<?= csrf_token() ?>">

                        <!-- Nombre Completo -->
                        <div class="mb-3">
                            <label class="form-label">Nombre Completo</label>
                            <input type="text"
                                class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>"
                                name="name"
                                value="<?= $old['name'] ?? '' ?>">
                            <?php if (isset($errors['name'])): ?>
                                <div class="invalid-feedback"><?= $errors['name'] ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label class="form-label">Correo Electrónico</label>
                            <input type="email"
                                class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                                name="email"
                                value="<?= $old['email'] ?? '' ?>">
                            <?php if (isset($errors['email'])): ?>
                                <div class="invalid-feedback"><?= $errors['email'] ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Teléfono -->
                        <div class="mb-3">
                            <label class="form-label">Teléfono</label>
                            <input type="tel"
                                class="form-control <?= isset($errors['phone']) ? 'is-invalid' : '' ?>"
                                name="phone"
                                value="<?= $old['phone'] ?? '' ?>">
                            <?php if (isset($errors['phone'])): ?>
                                <div class="invalid-feedback"><?= $errors['phone'] ?></div>
                            <?php endif; ?>
                        </div>
                        <!-- Usuario -->
                        <div class="mb-3">
                            <label class="form-label">Usuario</label>
                            <input type="text"
                                class="form-control <?= isset($errors['user']) ? 'is-invalid' : '' ?>"
                                name="user"
                                value="<?= $old['user'] ?? '' ?>">
                            <?php if (isset($errors['user'])): ?>
                                <div class="invalid-feedback"><?= $errors['user'] ?></div>
                            <?php endif; ?>
                        </div>
                        <!-- Contraseña -->
                        <div class="mb-3">
                            <label class="form-label">Contraseña</label>
                            <input type="password"
                                class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>"
                                name="password">
                            <?php if (isset($errors['password'])): ?>
                                <div class="invalid-feedback"><?= $errors['password'] ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Confirmar Contraseña -->
                        <div class="mb-3">
                            <label class="form-label">Confirmar Contraseña</label>
                            <input type="password"
                                class="form-control"
                                name="password_confirmation">
                        </div>

                        <!-- Sucursal -->
                        <div class="mb-3">
                            <label class="form-label">Sucursal Preferida</label>
                            <select class="form-select <?= isset($errors['office']) ? 'is-invalid' : '' ?>"
                                name="office">
                                <option value="">Seleccione una sucursal</option>
                                <?php foreach ($offices as $key => $value): ?>
                                    <option value="<?= $key ?>"
                                        <?= ($old['office'] ?? '') == $key ? 'selected' : '' ?>>
                                        <?= $value ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (isset($errors['office'])): ?>
                                <div class="invalid-feedback"><?= $errors['office'] ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Términos y Condiciones -->
                        <div class="mb-3 form-check">
                            <input type="checkbox"
                                class="form-check-input <?= isset($errors['terms']) ? 'is-invalid' : '' ?>"
                                name="terms"
                                id="terms"
                                <?= isset($old['terms']) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="terms">
                                Acepto los <a href="#terms">Términos y Condiciones</a>
                            </label>
                            <?php if (isset($errors['terms'])): ?>
                                <div class="invalid-feedback"><?= $errors['terms'] ?></div>
                            <?php endif; ?>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-person-check me-2"></i>Registrarse
                        </button>
                    </form>
                </div>

                <div class="card-footer text-center">
                    ¿Ya tienes cuenta?
                    <a href="<?= route('login') ?>" class="text-decoration-none">
                        Inicia Sesión
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>