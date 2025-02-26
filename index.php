<?php
require_once __DIR__ . DIRECTORY_SEPARATOR.'Core'.DIRECTORY_SEPARATOR.'configuration.php';

use Core\Router;
use App\Modelo\Modelo;
use App\Controllers\ModeloController;
$router = new Router();

// Añadir rutas
$router->addRoute('/', function() {
    echo "Bienvenido a la página de inicio!";
});

$router->addRoute('/modelo', function() {
    $modelo = new Modelo();
    echo "Esta es la página del modelo.";
});
$router->addRoute('/modelo/edit', [ModeloController::class, 'edit']);
// Obtener la ruta solicitada
$requestedRoute = $_SERVER['REQUEST_URI'];
// Despachar la ruta solicitada
$router->dispatch($requestedRoute);
