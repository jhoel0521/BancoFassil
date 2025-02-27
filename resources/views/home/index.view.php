<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bancofassil - Su Banco Digital</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background-color: #f5f5f5;
        }

        .header {
            background-color: #003366;
            color: white;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .rounded-image {
            width: 50px; 
            height: 50px;
            border-radius: 50%;
            object-fit: cover; 
        }
        .nav-links {
            display: flex;
            gap: 2rem;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
        }

        .hero {
            background: linear-gradient(rgba(0,51,102,0.8), rgba(0,51,102,0.8)),
                        url('<?=asset("images/bank-bg.avif")?>');
            background-size: cover;
            color: white;
            text-align: center;
            padding: 5rem 2rem;
        }

        .cta-buttons {
            margin-top: 2rem;
            display: flex;
            justify-content: center;
            gap: 1rem;
        }

        .btn {
            padding: 1rem 2rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1rem;
        }

        .btn-primary {
            background-color: #00CC66;
            color: white;
        }

        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            padding: 3rem 2rem;
        }

        .feature-card {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            text-align: center;
        }

        .footer {
            background-color: #003366;
            color: white;
            padding: 2rem;
            text-align: center;
            margin-top: 3rem;
        }

        .language-switcher {
            display: flex;
            gap: 1rem;
        }

        /* Estilos responsivos */
        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }
            
            .features {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="logo">
            <!-- Agregar logo aquí -->
            <img src="<?=asset('images/logo-bancofassil.jpg')?>" alt="Bancofassil" class="rounded-image">
            <h1>Bancofassil</h1>
        </div>
        <nav class="nav-links">
            <a href="#home">Inicio</a>
            <a href="#services">Servicios</a>
            <a href="#accounts">Cuentas</a>
            <a href="#contact">Contacto</a>
            <div class="language-switcher">
                <button>ES</button>
                <button>EN</button>
            </div>
        </nav>
    </header>

    <main>
        <section class="hero">
            <h2>Bienvenido a su Banco Digital</h2>
            <p>Gestiona tus finanzas de manera fácil y segura</p>
            <div class="cta-buttons">
                <button class="btn btn-primary">Acceder a Cuenta</button>
                <button class="btn btn-primary">Abrir Nueva Cuenta</button>
            </div>
        </section>

        <section class="features">
            <div class="feature-card">
                <h3>Operaciones en Línea</h3>
                <p>Realiza depósitos, retiros y consultas de saldo las 24 horas</p>
            </div>
            <div class="feature-card">
                <h3>Sucursales</h3>
                <p>Encuentra nuestra red de agencias a nivel nacional</p>
            </div>
            <div class="feature-card">
                <h3>Historial de Transacciones</h3>
                <p>Consulta y descarga tus movimientos bancarios</p>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div>
            <p>© 2023 Bancofassil - Desarrollo de Sistemas I</p>
            <p>Contacto: info@bancofassil.com | Teléfono: +591 12345678</p>
            <nav>
                <a href="#privacy">Política de Privacidad</a> | 
                <a href="#terms">Términos de Servicio</a>
            </nav>
        </div>
    </footer>
</body>
</html>