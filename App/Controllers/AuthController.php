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
    public function showRegisterForm()
    {
        $offices = [
            'La Paz',
            'Cochabamba',
            'Santa Cruz',
            'Tarija',
            'Beni',
            'Pando',
            'Oruro',
            'Potosí',
        ];
        return view('auth.register', compact('offices'));
    }
    public function register()
    {
        // Validar CSRF Token
        if (!csrf_verify($_POST['_token'])) {
            Session::flash('errors', ['general' => 'Token CSRF inválido']);
            Session::flash('old', $_POST);
            return redirect(route('register'));
        }

        // Validar datos
        $validator = new Validation();
        $rules = [
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:100|unique:Person,email',
            'phone' => 'nullable|string|max:20',
            'username' => 'required|string|max:50|unique:User,username',
            'password' => 'required|string|min:8|max:16|confirmed',
            'office' => 'required|int'
        ];
        
        if (!$validator->validate($_POST, $rules)) {
            Session::flash('errors', $validator->errors());
            Session::flash('old', $_POST);
            return redirect(route('register'));
        }

        try {
            // Iniciar transacción
            DB::getInstance()->getConnection()->beginTransaction();

            // Crear Persona
            $person = new Person();
            $person->name = $_POST['name'];
            $person->email = $_POST['email'];
            $person->phone = $_POST['phone'];
            $person->save();

            // Crear Usuario
            $user = new User();
            $user->username = $_POST['username'];
            $user->password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $user->personId = $person->id;
            $user->hasCard = false;
            $user->enabledForOnlinePurchases = false;
            $user->status = 'AC'; // Active por defecto
            $user->save();

            // Commit transacción
            DB::getInstance()->getConnection()->commit();

            Session::flash('success', 'Registro exitoso. Ahora puede iniciar sesión.');
            return redirect(route('login'));

        } catch (\Exception $e) {
            // Rollback en caso de error
            DB::getInstance()->getConnection()->rollBack();
            
            Session::flash('errors', ['general' => 'Error al registrar el usuario: ' . $e->getMessage()]);
            Session::flash('old', $_POST);
            return redirect(route('register'));
        }
    }
}
