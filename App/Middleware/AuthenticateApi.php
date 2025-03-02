<?php

namespace App\Middleware;

use App\Enums\StatusCode;
use Core\Request;
use Core\Response;
use App\Models\Token;

class AuthenticateApi
{
    public function handle(Request $request, $next)
    {
        // Obtener el token del encabezado Authorization
        $token = $request->header('Authorization');

        if (!$token || !Token::isValid($token)) {
            return Response::json([
                'success' => false,
                'message' => 'No autorizado'
            ], StatusCode::UNAUTHORIZED);
        }

        // Obtener el usuario asociado al token
        $user = Token::getUserByToken($token);

        if (!$user) {
            return Response::json([
                'success' => false,
                'message' => 'Usuario no encontrado'
            ], StatusCode::NOT_FOUND);
        }

        // Asignar el usuario a la solicitud
        $request->setUser($user);

        return $next($request);
    }
}
