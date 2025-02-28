<?php

require_once __DIR__ . '/Core/configuration.php';
require_once __DIR__ . '/Core/Router.php';

use Core\Router;
use Core\Request;
// Cargar rutas desde la carpeta /routes
$request = new Request();
Router::loadRoutes(BASE_ROUTE . 'routes');

// Obtener la ruta solicitada
$requestedRoute = strtok($_SERVER['REQUEST_URI'], '?'); // Elimina query params
$method = $_SERVER['REQUEST_METHOD'];
// Despachar la ruta solicitada
$response = Router::dispatch($request);
$response->send();
