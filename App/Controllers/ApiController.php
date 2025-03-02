<?php

namespace App\Controllers;

use Core\Request;
use Core\Response;

class ApiController
{
    protected function success($data = [], $statusCode = 200)
    {
        return Response::json([
            'success' => true,
            'data' => $data
        ], $statusCode);
    }

    protected function validateRequest(Request $request, array $rules)
    {
        // Implementar lógica de validación
        // Puedes usar tu clase Validation aquí
    }
}