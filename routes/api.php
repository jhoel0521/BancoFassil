<?php

use App\Controllers\AuthApiController;
use App\Middleware\AuthenticateApi;
use Core\Router;

// se deve usar la constante API_PREFIX para definir la ruta de la api


// rutas de login

Router::post(API_PREFIX . '/login', [AuthApiController::class, 'login'])->name('api.auth.login');

// me
Router::post(API_PREFIX . '/me', [AuthApiController::class, 'me'])->name('api.auth.me')->middleware(AuthenticateApi::class);
// getAccounts
Router::get(API_PREFIX . '/accounts', [AuthApiController::class, 'accounts'])->name('api.auth.getAccounts')->middleware(AuthenticateApi::class);