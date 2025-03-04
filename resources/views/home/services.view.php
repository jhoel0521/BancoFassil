<main class="container my-5">
    <h1 class="display-4 text-center mb-5">📲 Banco Digital - Servicios en Línea</h1>

    <!-- Sección de Servicios Bancarios -->
    <div class="row g-4">
        <!-- Cuentas -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow">
                <div class="card-header bg-primary text-white">
                    <h2 class="h5 mb-0"><i class="bi bi-cash-coin me-2"></i>Cuentas Bancarias</h2>
                </div>
                <div class="card-body">
                    <p class="card-text">Administra tus cuentas bancarias de manera segura:</p>
                    <ul class="list-unstyled">
                        <li><i class="bi bi-plus-circle me-2"></i>Crear nuevas cuentas</li>
                        <li><i class="bi bi-eye me-2"></i>Consultar saldos</li>
                        <li><i class="bi bi-x-circle me-2"></i>Cerrar cuentas</li>
                    </ul>
                    <a href="<?= route('account.create') ?>" class="btn btn-primary w-100">
                        <i class="bi bi-plus-lg me-2"></i>Nueva Cuenta
                    </a>
                </div>
            </div>
        </div>

        <!-- Transferencias -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow">
                <div class="card-header bg-success text-white">
                    <h2 class="h5 mb-0"><i class="bi bi-arrow-left-right me-2"></i>Transferencias</h2>
                </div>
                <div class="card-body">
                    <p class="card-text">Realiza transferencias entre cuentas:</p>
                    <div class="mb-3">
                        <i class="bi bi-shield-lock me-2"></i>Transacciones seguras
                    </div>
                    <div class="mb-3">
                        <i class="bi bi-clock-history me-2"></i>Disponible 24/7
                    </div>
                    <a href="<?= route('account.index') ?>" class="btn btn-success w-100">
                        <i class="bi bi-send me-2"></i>Transferir Fondos
                    </a>
                </div>
            </div>
        </div>

        <!-- Tarjetas -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow">
                <div class="card-header bg-warning text-dark">
                    <h2 class="h5 mb-0"><i class="bi bi-credit-card me-2"></i>Tarjetas</h2>
                </div>
                <div class="card-body">
                    <p class="card-text">Administra tus tarjetas asociadas:</p>
                    <ul class="list-unstyled">
                        <li><i class="bi bi-plus-circle me-2"></i>Solicitar nuevas tarjetas</li>
                        <li><i class="bi bi-toggle-on me-2"></i>Activar/Desactivar</li>
                        <li><i class="bi bi-globe me-2"></i>Control compras online</li>
                    </ul>
                    <a href="<?= route('account.index') ?>" class="btn btn-warning w-100">
                        <i class="bi bi-credit-card-2-front me-2"></i>Gestionar Tarjetas
                    </a>
                </div>
            </div>
        </div>

        <!-- Servicios Adicionales -->
        <div class="col-12 mt-4">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h2 class="h5 mb-0"><i class="bi bi-puzzle me-2"></i>Servicios Adicionales</h2>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-atm fs-1 me-3"></i>
                                <div>
                                    <h3 class="h5">Cajeros Automáticos</h3>
                                    <p class="mb-0">Simula operaciones en cajeros automáticos (proyecto ATMs)</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-cart-check fs-1 me-3"></i>
                                <div>
                                    <h3 class="h5">Tienda Online</h3>
                                    <p class="mb-0">Simula compras en nuestra tienda virtual asociada</p>
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
        <h3 class="h5"><i class="bi bi-shield-lock me-2"></i>Seguridad</h3>
        <p class="mb-0">
            Todas las operaciones están protegidas con nuestro sistema de seguridad bancaria.
        </p>
    </div>
</main>