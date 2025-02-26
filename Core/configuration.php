<?php
define('BASE_ROUTE', dirname(__DIR__) . DIRECTORY_SEPARATOR);

// Ajusta las rutas de los archivos requeridos
require_once BASE_ROUTE . 'functions.php';
require_once BASE_ROUTE . 'App' . DIRECTORY_SEPARATOR . 'Modelo' . DIRECTORY_SEPARATOR . 'Modelo.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Router.php'; // Core/Router.php está en el mismo nivel
