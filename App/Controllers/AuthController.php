<?php

namespace App\Controllers;

use Core\Router;
use Core\Session;
use Core\Validation;
use Core\DB;
use App\Models\Person;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login', ['title' => traducir('inicia_sesión')]);
    }

    public function login()
    {
        // Validar Validation
        $validator = new Validation();
        $rules = [
            'user' => 'required|string|max:50',
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
            $route = route('home');
            if (Session::has('back')) {
                $route = Session::get('back');
                Session::remove('back');
            }
            return redirect($route);
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
        $users = User::where('status', '=', 'AC')->where('username', '=', $user)->first();
        if (!isset($users)) {
            return false;
        }
        if (password_verify($password, $users->password)) {
            return $users;
        }
        return false;
    }
    public function showRegisterForm()
    {
        return view('auth.register');
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
            'user' => 'required|string|max:50|unique:User,user',
            'password' => 'required|string|min:8|max:16|confirmed'
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
            $user->username = $_POST['user'];
            $user->password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $user->personId = $person->id;
            $user->hasCard = 0;
            $user->enabledForOnlinePurchases = 0;
            $user->status = 'AC';
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
