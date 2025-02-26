<?php
use Core\Router;
use App\Controllers\HomeController;
use App\Controllers\AuthController;

Router::get('/', [HomeController::class, 'index'])->name('home');
Router::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Router::post('/login', [AuthController::class, 'login'])->name('auth.login');
Router::get('/logout', [AuthController::class, 'logout'])->name('logout');
