<?php

use Core\Router;
use App\Controllers\HomeController;
use App\Controllers\ModeloController;

Router::get('/', [HomeController::class, 'index']);
Router::get('/modelo', [ModeloController::class, 'index']);
Router::get('/modelo/edit', [ModeloController::class, 'edit']);
