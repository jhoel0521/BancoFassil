<?php

namespace App\Controllers;

use Core\Router;
use Core\Session;
use Core\Validation;

class AuthController
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login()
    {
        // Validar CSRF Token
        if (!csrf_verify($_POST['_token'])) {
            Session::flash('errors', ['general' => 'Token CSRF inválido']);
            Session::flash('old', $_POST);
            return Router::redirect(route('login'));
        }

        // Validar Validation
        $validator = new Validation();
        $validator->validate($_POST, [
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        if ($validator->fails()) {
            Session::flash('errors', $validator->errors());
            Session::flash('old', $_POST);
            return Router::redirect(route('login'));
        }

        // Autenticar usuario (ejemplo básico)
        $user = $this->attempt($_POST['email'], $_POST['password']);

        if ($user) {
            Session::set('user', $user);
            return Router::redirect(route('home'));
        }

        Session::flash('errors', ['general' => 'Credenciales incorrectas']);
        Session::flash('old', $_POST);
        return Router::redirect(route('login'));
    }

    public function logout()
    {
        Session::destroy();
        return Router::redirect(route('home'));
    }

    private function attempt($email, $password)
    {
        // Lógica real de autenticación con base de datos
        // Ejemplo temporal:
        $users = [
            'admin@bancofassil.com' => password_hash('password123', PASSWORD_DEFAULT)
        ];

        if (isset($users[$email]) && password_verify($password, $users[$email])) {
            return ['email' => $email, 'name' => 'Usuario Demo'];
        }

        return false;
    }
}