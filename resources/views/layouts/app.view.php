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
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Contenido principal -->
    <main class="main-content">
        <?= $content ?>
    </main>
    <!-- Footer -->
    <footer class="bg-primary text-white mt-auto py-4 fixed-bottom">
        <div class="container text-center">
            <p class="mb-2">© 2023 BancoFassil - Desarrollo de Sistemas I</p>
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