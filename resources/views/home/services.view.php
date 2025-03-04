<main class="container my-5">
    <h1 class="display-4 text-center mb-5">📲 <?= traducir('bienvenida') ?></h1>

    <!-- Sección de Servicios Bancarios -->
    <div class="row g-4">
        <!-- Cuentas -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow">
                <div class="card-header bg-primary text-white">
                    <h2 class="h5 mb-0"><i class="bi bi-cash-coin me-2"></i><?= traducir('cuentas') ?></h2>
                </div>
                <div class="card-body">
                    <p class="card-text"><?= traducir('administrar_cuentas') ?>:</p>
                    <ul class="list-unstyled">
                        <li><i class="bi bi-plus-circle me-2"></i><?= traducir('crear_cuenta') ?></li>
                        <li><i class="bi bi-eye me-2"></i><?= traducir('consultar_saldos') ?></li>
                        <li><i class="bi bi-x-circle me-2"></i><?= traducir('cerrar_cuentas') ?></li>
                    </ul>
                    <a href="<?= route('account.create') ?>" class="btn btn-primary w-100">
                        <i class="bi bi-plus-lg me-2"></i><?= traducir('abrir_cuenta') ?>
                    </a>
                </div>
            </div>
        </div>

        <!-- Transferencias -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow">
                <div class="card-header bg-success text-white">
                    <h2 class="h5 mb-0"><i class="bi bi-arrow-left-right me-2"></i><?= traducir('transferencia') ?></h2>
                </div>
                <div class="card-body">
                    <p class="card-text"><?= traducir('realizar_transferencias') ?>:</p>
                    <div class="mb-3">
                        <i class="bi bi-shield-lock me-2"></i><?= traducir('transacciones_seguras') ?>
                    </div>
                    <div class="mb-3">
                        <i class="bi bi-clock-history me-2"></i><?= traducir('disponible_24_7') ?>
                    </div>
                    <a href="<?= route('account.index') ?>" class="btn btn-success w-100">
                        <i class="bi bi-send me-2"></i><?= traducir('transferir_fondos') ?>
                    </a>
                </div>
            </div>
        </div>

        <!-- Tarjetas -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow">
                <div class="card-header bg-warning text-dark">
                    <h2 class="h5 mb-0"><i class="bi bi-credit-card me-2"></i><?= traducir('tarjetas') ?></h2>
                </div>
                <div class="card-body">
                    <p class="card-text"><?= traducir('administrar_tarjetas') ?>:</p>
                    <ul class="list-unstyled">
                        <li><i class="bi bi-plus-circle me-2"></i><?= traducir('solicitar_tarjetas') ?></li>
                        <li><i class="bi bi-toggle-on me-2"></i><?= traducir('activar_desactivar') ?></li>
                        <li><i class="bi bi-globe me-2"></i><?= traducir('control_compras_online') ?></li>
                    </ul>
                    <a href="<?= route('account.index') ?>" class="btn btn-warning w-100">
                        <i class="bi bi-credit-card-2-front me-2"></i><?= traducir('gestionar_tarjetas') ?>
                    </a>
                </div>
            </div>
        </div>

        <!-- Servicios Adicionales -->
        <div class="col-12 mt-4">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h2 class="h5 mb-0"><i class="bi bi-puzzle me-2"></i><?= traducir('servicios_adicionales') ?></h2>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-atm fs-1 me-3"></i>
                                <div>
                                    <h3 class="h5"><?= traducir('cajeros_automaticos') ?></h3>
                                    <p class="mb-0"><?= traducir('sucursales_desc') ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-cart-check fs-1 me-3"></i>
                                <div>
                                    <h3 class="h5"><?= traducir('compra_en_línea') ?></h3>
                                    <p class="mb-0"><?= traducir('tienda_virtual_desc') ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de Seguridad -->
    <div class="alert alert-warning mt-4">
        <h3 class="h5"><i class="bi bi-shield-lock me-2"></i><?= traducir('seguridad') ?></h3>
        <p class="mb-0">
            <?= traducir('operaciones_protegidas') ?>
        </p>
    </div>
</main>