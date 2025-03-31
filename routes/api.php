<?php

use App\Controllers\AuthApiController;
use App\Middleware\AuthenticateApi;
use Core\Router;

// se debe usar la constante API_PREFIX para definir la ruta de la api


// rutas de login

Router::post(API_PREFIX . '/login', [AuthApiController::class, 'login'])->name('api.auth.login');

// me
Router::post(API_PREFIX . '/me', [AuthApiController::class, 'me'])->name('api.auth.me')->middleware(AuthenticateApi::class);
// getAccounts
Router::get(API_PREFIX . '/accounts', [AuthApiController::class, 'accounts'])->name('api.auth.getAccounts')->middleware(AuthenticateApi::class);

// getHistorialTransacciones
Router::get(API_PREFIX . '/transactions', [AuthApiController::class, 'transactions'])->name('api.auth.transactions')->middleware(AuthenticateApi::class);

// account/withdraw
Router::post(API_PREFIX . '/account/withdraw', [AuthApiController::class, 'withdraw'])->name('api.auth.withdraw')->middleware(AuthenticateApi::class);
// account/deposit
Router::post(API_PREFIX . '/account/deposit', [AuthApiController::class, 'deposit'])->name('api.auth.deposit')->middleware(AuthenticateApi::class);
// purchase/online
Router::post(API_PREFIX . '/purchase/online', [AuthApiController::class, 'purchaseOnline'])->name('api.auth.purchaseOnline')->middleware(AuthenticateApi::class);

// logout
Router::post(API_PREFIX . '/logout', [AuthApiController::class, 'logout'])->name('api.auth.logout')->middleware(AuthenticateApi::class);