<?php

use App\Controllers\AuthApiController;
use Core\Router;

// se deve usar la constante API_PREFIX para definir la ruta de la api


// rutas de login

Router::post(API_PREFIX . '/login', [AuthApiController::class, 'login'])->name('auth.login');
