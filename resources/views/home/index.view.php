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
        .custom-bg-gradient {
            background: linear-gradient(rgba(0, 51, 102, 0.8), rgba(0, 51, 102, 0.8)),
                url('<?= asset("images/bank-bg.avif") ?>');
            background-size: cover;
        }

        .feature-card {
            transition: transform 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">
    <!-- Header -->
    <header class="bg-primary text-white fixed-top shadow-sm">
        <nav class="navbar navbar-expand-lg container">
            <div class="container-fluid">
                <a class="navbar-brand d-flex align-items-center" href="#">
                    <img src="<?= asset('images/logo-bancofassil.jpg') ?>"
                        alt="Bancofassil"
                        class="rounded-circle me-2"
                        style="width: 50px; height: 50px; object-fit: cover;">
                    <h1 class="h4 mb-0">Bancofassil</h1>
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
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Contenido principal -->
    <main class="flex-grow-1 mt-5 pt-4">
        <!-- Hero Section -->
        <section class="custom-bg-gradient text-white py-5">
            <div class="container text-center py-5">
                <h2 class="display-4 mb-4">Bienvenido a su Banco Digital</h2>
                <p class="lead mb-4">Gestiona tus finanzas de manera fácil y segura</p>
                <div class="d-flex gap-3 justify-content-center">
                    <a class="btn btn-success btn-lg" href="<?= route('login') ?>">
                        <i class="bi bi-person-check me-2"></i>Acceder a Cuenta
                    </a>
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

    <!-- Footer -->
    <footer class="bg-primary text-white mt-auto py-4 fixed-bottom">
        <div class="container text-center">
            <p class="mb-2">© 2023 Bancofassil - Desarrollo de Sistemas I</p>
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>