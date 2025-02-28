<?php

use Core\Router;
use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\ChangeLanguageController;
Router::get('/', [HomeController::class, 'index'])->name('home');
Router::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Router::post('/login', [AuthController::class, 'login'])->name('auth.login');
Router::get('/logout', [AuthController::class, 'logout'])->name('logout');
Router::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Router::post('/register', [AuthController::class, 'register'])->name('auth.register');


Router::post('/change-language', [ChangeLanguageController::class, 'changeLanguage'])->name('change.language');
 
Router::post('/change-language', [ChangeLanguageController::class, 'changeLanguage'])->name('change-language');
