<div class="flex-grow-1 pt-4">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center">
                    <h2 class="mb-0"><i class="bi bi-bank me-2"></i> <?= traducir('banco_fassil') ?></h2>
                </div>

                <div class="card-body">
                    <form action="<?= route('auth.login') ?>" method="POST">
                        <!-- CSRF Token -->
                        <input type="hidden" name="_token" value="<?= csrf_token() ?>">

                        <!-- Usuario -->
                        <div class="mb-3">
                            <label for="user" class="form-label"> <?= traducir('usuario') ?></label>
                            <input type="text"
                                class="form-control <?= isset($errors['user']) ? 'is-invalid' : '' ?>"
                                id="user"
                                name="user"
                                value="<?= $old['user'] ?? '' ?>"
                                required>
                            <?php if (isset($errors['user'])): ?>
                                <div class="invalid-feedback"><?= $errors['user'] ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Contraseña -->
                        <div class="mb-3">
                            <label for="password" class="form-label"> <?= traducir('contraseña') ?></label>
                            <input type="password"
                                class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>"
                                id="password"
                                name="password"
                                minlength="8"
                                required>
                            <?php if (isset($errors['password'])): ?>
                                <div class="invalid-feedback"><?= $errors['password'] ?? '' ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Sección de errores generales -->
                        <?php if (isset($errors['general'])): ?>
                            <div class="alert alert-danger"><?= $errors['general'] ?></div>
                        <?php endif; ?>

                        <!-- Recordar sesión -->
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember"> <?= traducir('recordar_sesión') ?></label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-box-arrow-in-right me-2"></i> <?= traducir('iniciar_sesión') ?>
                        </button>
                    </form>
                </div>

                <div class="card-footer text-center">
                    <a href="<?= route('password.request') ?>" class="text-decoration-none">
                        <?= traducir('olvidaste_contraseña') ?>
                    </a>
                    <div class="mt-2">
                        <?= traducir('registrarse_aquí') ?>
                        <a href="<?= route('register') ?>" class="text-decoration-none">
                            <?= traducir('registrarse_aquí') ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>