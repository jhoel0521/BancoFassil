<?php

namespace App\Controllers;

use Core\Request;
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
        // Validar datos
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

        // Autenticar usuario
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

        Session::flash('errors', ['general' => traducir('credenciales_incorrectas')]);
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
        return view('auth.register', ['title' => traducir('registrarse')]);
    }

    public function register(Request $request)
    {
        // Validar CSRF Token
        if (!csrf_verify($_POST['_token'])) {
            Session::flash('errors', ['general' => traducir('csrf_invalido')]);
            Session::flash('old', $_POST);
            return redirect(route('register'));
        }

        // Validar datos
        $validator = new Validation();
        $rules = [
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:100|unique:Person,email',
            'phone' => 'nullable|string|max:20|min:8',
            'user' => 'required|string|max:50|unique:User,username',
            'password' => 'required|string|min:8|max:16|confirmed',
            'terms' => 'required|in:on',
        ];
        if (!$validator->validate($request->all(), $rules)) {
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

            Session::flash('success', traducir('registro_exitoso'));
            return redirect(route('login'));
        } catch (\Exception $e) {
            // Rollback en caso de error
            DB::getInstance()->getConnection()->rollBack();
            Session::flash('errors', ['general' => traducir('error_registro') . ': ' . $e->getMessage()]);
            Session::flash('old', $_POST);
            return redirect(route('register'));
        }
    }
}
