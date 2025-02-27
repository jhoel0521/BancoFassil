<?php

namespace App\Controllers;

class AuthController
{
    public function login()
    {
        return view('auth.login');
    }

    public function authenticate()
    {
        // Simulación de autenticación básica
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if ($username === 'admin' && $password === 'password') {
            $_SESSION['user'] = $username;
            header('Location: /');
            exit;
        }

        return view('auth/.ogin', ['error' => 'Credenciales incorrectas']);
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: /login');
        exit;
    }
}
