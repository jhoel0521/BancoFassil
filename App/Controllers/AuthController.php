<?php

namespace App\Controllers;

use Core\Router;
use Core\Session;
use Core\Validation;

class AuthController extends Controller
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
            return redirect(route('login'));
        }

        // Validar Validation
        $validator = new Validation();
        $rules = [
            'user'    => 'required|user',
            'password' => 'required|min:8|max:16'
        ];
        if (!$validator->validate($_POST, $rules)) {
            Session::flash('errors', $validator->errors());
            Session::flash('old', $_POST);
            return redirect(route('login'));
        }
        
        // Autenticar usuario (ejemplo básico)
        $user = $this->attempt($_POST['user'], $_POST['password']);

        if ($user) {
            Session::set('user', $user);
            return redirect(route('home'));
        }

        Session::flash('errors', ['general' => 'Credenciales incorrectas']);
        Session::flash('old', $_POST);
        return redirect(route('login'));
    }

    public function logout()
    {
        Session::destroy();
        return redirect(route('home'));
    }

    private function attempt($user, $password)
    {
        // Lógica real de autenticación con base de datos
        // Ejemplo temporal:
        $users = [
            'admin@bancofassil.com' => password_hash('password123', PASSWORD_DEFAULT)
        ];

        if (isset($users[$user]) && password_verify($password, $users[$user])) {
            return ['user' => $user, 'name' => 'Usuario Demo'];
        }

        return false;
    }
}
