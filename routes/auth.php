<?php

use Core\Router;
use App\Controllers\AuthController;

Router::get('/login', [AuthController::class, 'login']);
Router::post('/login', [AuthController::class, 'authenticate']);
Router::post('/logout', [AuthController::class, 'logout']);
