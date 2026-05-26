<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    protected function successResponse($data, int $code = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $data
        ], $code);
    }

    protected function errorResponse(string $message, int $code, array $errors = []): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if (!empty($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }
}

