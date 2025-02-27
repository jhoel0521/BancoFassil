<?php

require_once __DIR__ . '/Core/configuration.php';
require_once __DIR__ . '/Core/Router.php';

use Core\Router;

// Cargar rutas desde la carpeta /routes
Router::loadRoutes(BASE_ROUTE . 'routes');

// Obtener la ruta solicitada
$requestedRoute = strtok($_SERVER['REQUEST_URI'], '?'); // Elimina query params
$method = $_SERVER['REQUEST_METHOD'];
route('login');
// Despachar la ruta solicitada
Router::dispatch($requestedRoute, $method);
