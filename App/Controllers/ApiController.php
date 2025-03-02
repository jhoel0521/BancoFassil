<?php

namespace App\Controllers;

use App\Enums\StatusCode;
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
    protected function error($data = [], $statusCode = StatusCode::BAD_REQUEST)
    {
        return Response::json([
            'success' => false,
            'data' => $data
        ], $statusCode);
    }
}
