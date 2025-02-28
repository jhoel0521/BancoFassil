<?php
require_once __DIR__ . '/../../../App/config/translations.php';
?>

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
            <h2 class="display-4 mb-4"><?= $translations[$lang]['bienvenida'] ?></h2>
            <p class="lead mb-4"><?= $translations[$lang]['subtitulo'] ?></p>
            <div class="d-flex gap-3 justify-content-center">
                <?php if (isAuth()): ?>
                    <a class="btn btn-primary btn-lg" href="<?= route('dashboard') ?>">
                        <i class="bi bi-person-fill me-2"></i><?= $translations[$lang]['ir_cuentas'] ?>
                    </a>
                <?php else: ?>
                    <a class="btn btn-success btn-lg" href="<?= route('login') ?>">
                        <i class="bi bi-person-check me-2"></i><?= $translations[$lang]['acceder'] ?>
                    </a>
                <?php endif; ?>
                <button class="btn btn-outline-light btn-lg">
                    <i class="bi bi-plus-circle me-2"></i><?= $translations[$lang]['abrir_cuenta'] ?>
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
                        <h3 class="h4"><?= $translations[$lang]['operaciones'] ?></h3>
                        <p><?= $translations[$lang]['operaciones_desc'] ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card card h-100 shadow">
                    <div class="card-body text-center">
                        <i class="bi bi-geo-alt fs-1 text-primary mb-3"></i>
                        <h3 class="h4"><?= $translations[$lang]['sucursales'] ?></h3>
                        <p><?= $translations[$lang]['sucursales_desc'] ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card card h-100 shadow">
                    <div class="card-body text-center">
                        <i class="bi bi-clock-history fs-1 text-primary mb-3"></i>
                        <h3 class="h4"><?= $translations[$lang]['historial'] ?></h3>
                        <p><?= $translations[$lang]['historial_desc'] ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
