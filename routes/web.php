<?php

use Core\Router;
use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\ChangeLanguageController;
use App\Controllers\AccountController;
use App\Middleware\AuthMiddleware;

Router::get('/', [HomeController::class, 'index'])->name('home');
Router::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Router::post('/login', [AuthController::class, 'login'])->name('auth.login');
Router::get('/logout', [AuthController::class, 'logout'])->name('logout');
Router::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Router::post('/register', [AuthController::class, 'register'])->name('auth.register');


Router::get('/change-language/{lang}', [ChangeLanguageController::class, 'changeLanguage'])->name('change.language');

Router::get('/AccountController', [AccountController::class, 'index'])->name('account.index')->middleware(AuthMiddleware::class);
Router::get('/account/create', [AccountController::class, 'create'])->name('account.create')->middleware(AuthMiddleware::class);
Router::post('/account/store', [AccountController::class, 'store'])->name('account.store')->middleware(AuthMiddleware::class);

Router::get('/account/{id}', [AccountController::class, 'show'])->name('account.show')->middleware(AuthMiddleware::class);
Router::delete('/account/{id}', [AccountController::class, 'destroy'])->name('account.destroy')->middleware(AuthMiddleware::class);
Router::post('/account/{id}/transfer', [AccountController::class, 'transfer'])->name('account.transfer')->middleware(AuthMiddleware::class);
Router::post('/account/{id}/card/create', [AccountController::class, 'create'])->name('card.create')->middleware(AuthMiddleware::class);
