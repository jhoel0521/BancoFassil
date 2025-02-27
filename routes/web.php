<?php
use Core\Router;
use App\Controllers\HomeController;
use App\Controllers\AuthController;

Router::get('/', [HomeController::class, 'index'])->name('home');
Router::get('/login', [AuthController::class, 'login'])->name('login');
Router::post('/login', [AuthController::class, 'authenticate'])->name('auth.login');
Router::get('/logout', [AuthController::class, 'logout'])->name('logout');
