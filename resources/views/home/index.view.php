<main class="flex-grow-1 mt-5 pt-4">
    <!-- Hero Section -->
    <style>
        .custom-bg-gradient {
            background: linear-gradient(rgba(0, 51, 102, 0.8), rgba(0, 51, 102, 0.8)),
                url('<?= asset("images/bank-bg.avif") ?>');
            background-size: cover;
            border-radius: 20px;
        }

        .feature-card {
            transition: transform 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
    </style>

    <section class="custom-bg-gradient text-white py-5">
        <div class="container text-center py-5">
            <h2 class="display-4 mb-4"><?= traducir('bienvenida') ?></h2>
            <p class="lead mb-4"><?= traducir('subtítulo') ?></p>
            <p class="lead mb-4"><?= traducir('descripcion-meta') ?></p>
            <div class="d-flex gap-3 justify-content-center">
                <?php if (isAuth()): ?>
                    <a class="btn btn-primary btn-lg" href="<?= route('account.index') ?>">
                        <i class="bi bi-person-fill me-2"></i><?= traducir('ir_cuentas') ?>
                    </a>
                <?php else: ?>
                    <a class="btn btn-success btn-lg" href="<?= route('login') ?>">
                        <i class="bi bi-person-check me-2"></i><?= traducir('acceder') ?>
                    </a>
                <?php endif; ?>
                <a class="btn btn-outline-light btn-lg" href="<?= route('account.create') ?>">
                    <i class="bi bi-plus-circle me-2"></i><?= traducir('abrir_cuenta') ?>
                </a>
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
                        <h3 class="h4"><?= traducir('operaciones') ?></h3>
                        <p><?= traducir('operaciones_desc') ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card card h-100 shadow">
                    <div class="card-body text-center">
                        <i class="bi bi-geo-alt fs-1 text-primary mb-3"></i>
                        <h3 class="h4"><?= traducir('sucursales') ?></h3>
                        <p><?= traducir('sucursales_desc') ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card card h-100 shadow">
                    <div class="card-body text-center">
                        <i class="bi bi-clock-history fs-1 text-primary mb-3"></i>
                        <h3 class="h4"><?= traducir('historial') ?></h3>
                        <p><?= traducir('historial_desc') ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>