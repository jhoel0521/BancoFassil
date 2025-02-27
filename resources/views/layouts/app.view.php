<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BancoFassil - Su Banco Digital</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        /* Nuevos estilos agregados */
        body {
            padding-top: 80px;
            /* Para el header fijo */
            padding-bottom: 100px;
            /* Para el footer fijo */
        }

        .main-content {
            flex: 1;
            padding: 2rem 0;
        }

        .fixed-footer {
            position: relative;
            /* Cambiado de fixed-bottom */
            margin-top: auto;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">
    <!-- Header (código anterior igual) ... -->
    <header class="bg-primary text-white fixed-top shadow-sm">
        <nav class="navbar navbar-expand-lg container">
            <div class="container-fluid">
                <a class="navbar-brand d-flex align-items-center" href="#">
                    <img src="<?= asset('images/logo-BancoFassil.jpg') ?>"
                        alt="BancoFassil"
                        class="rounded-circle me-2"
                        style="width: 50px; height: 50px; object-fit: cover;">
                    <h1 class="h4 mb-0">BancoFassil</h1>
                </a>

                <button class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon text-white"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#home">
                                <i class="bi bi-house-door me-1"></i>Inicio
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#services">
                                <i class="bi bi-wallet2 me-1"></i>Servicios
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#accounts">
                                <i class="bi bi-bank me-1"></i>Cuentas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#contact">
                                <i class="bi bi-chat-dots me-1"></i>Contacto
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link text-white dropdown-toggle"
                                href="#"
                                role="button"
                                data-bs-toggle="dropdown">
                                <i class="bi bi-translate me-1"></i>Idioma
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">ES</a></li>
                                <li><a class="dropdown-item" href="#">EN</a></li>
                            </ul>
                        </li>
                        <?php if (isAuth()): ?>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="<?= route('dashboard') ?>">
                                    <i class="bi bi-person-fill me-1"></i>Mi Cuenta
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="<?= route('logout') ?>">
                                    <i class="bi bi-box-arrow-right me-1"></i>Cerrar Sesión
                                </a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="<?= route('login') ?>">
                                    <i class="bi bi-box-arrow-in-right me-1"></i>Iniciar Sesión
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <!-- Contenido principal modificado -->
    <main class="main-content">
        <div class="container">
            <?= $content ?>
        </div>
    </main>

    <!-- Footer modificado -->
    <footer class="bg-primary text-white py-4 fixed-footer">
        <div class="container text-center">
            <p class="mb-2">© 2024 BancoFassil - Desarrollo de Sistemas I</p>
            <p class="mb-2">
                <i class="bi bi-envelope me-2"></i>info@bancofassil.com
                <i class="bi bi-telephone ms-3 me-2"></i>+591 12345678
            </p>
            <nav class="d-flex justify-content-center gap-3">
                <a href="#privacy" class="text-white text-decoration-none">
                    Política de Privacidad
                </a>
                <span>|</span>
                <a href="#terms" class="text-white text-decoration-none">
                    Términos de Servicio
                </a>
            </nav>
        </div>
    </footer>

    <!-- ... (scripts igual) ... -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>