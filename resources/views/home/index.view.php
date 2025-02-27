<main class="flex-grow-1 mt-5 pt-4">
    <!-- Hero Section -->
    <section class="custom-bg-gradient text-white py-5">
        <div class="container text-center py-5">
            <h2 class="display-4 mb-4">Bienvenido a su Banco Digital</h2>
            <p class="lead mb-4">Gestiona tus finanzas de manera fácil y segura</p>
            <div class="d-flex gap-3 justify-content-center">
                <?php if (isAuth()): ?>
                    <a class="btn btn-primary btn-lg" href="<?= route('dashboard') ?>">
                        <i class="bi bi-person-fill me-2"></i>Ir a Mis Cuentas
                    </a>
                <?php else: ?>
                    <a class="btn btn-success btn-lg" href="<?= route('login') ?>">
                        <i class="bi bi-person-check me-2"></i>Acceder a Cuenta
                    </a>
                <?php endif; ?>
                <button class="btn btn-outline-light btn-lg">
                    <i class="bi bi-plus-circle me-2"></i>Abrir Nueva Cuenta
                </button>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="container py-5">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card card h-100 shadow">
                    <div class="card-body text-center">
                        <i class="bi bi-credit-card fs-1 text-primary mb-3"></i>
                        <h3 class="h4">Operaciones en Línea</h3>
                        <p>Realiza depósitos, retiros y consultas de saldo las 24 horas</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card card h-100 shadow">
                    <div class="card-body text-center">
                        <i class="bi bi-geo-alt fs-1 text-primary mb-3"></i>
                        <h3 class="h4">Sucursales</h3>
                        <p>Encuentra nuestra red de agencias a nivel nacional</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card card h-100 shadow">
                    <div class="card-body text-center">
                        <i class="bi bi-clock-history fs-1 text-primary mb-3"></i>
                        <h3 class="h4">Historial de Transacciones</h3>
                        <p>Consulta y descarga tus movimientos bancarios</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>