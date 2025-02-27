<?php
$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']);
$old = $_SESSION['old'] ?? [];
unset($_SESSION['old']);
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center">
                    <h2 class="mb-0"><i class="bi bi-bank me-2"></i>BancoFassil</h2>
                </div>
                
                <div class="card-body">
                    <form action="<?= route('auth.login') ?>" method="POST">
                        <!-- CSRF Token -->
                        <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                        
                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="email" 
                                   class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" 
                                   id="email" 
                                   name="email" 
                                   value="<?= $old['email'] ?? '' ?>"
                                   required>
                            <?php if(isset($errors['email'])): ?>
                                <div class="invalid-feedback"><?= $errors['email'] ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Contraseña -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" 
                                   class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" 
                                   id="password" 
                                   name="password" 
                                   minlength="8"
                                   required>
                            <?php if(isset($errors['password'])): ?>
                                <div class="invalid-feedback"><?= $errors['password'] ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Recordar Sesión -->
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Recordar sesión</label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar Sesión
                        </button>
                    </form>
                </div>

                <div class="card-footer text-center">
                    <a href="<?= route('password.request') ?>" class="text-decoration-none">
                        ¿Olvidaste tu contraseña?
                    </a>
                    <div class="mt-2">
                        ¿No tienes cuenta? 
                        <a href="<?= route('register') ?>" class="text-decoration-none">
                            Regístrate aquí
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>