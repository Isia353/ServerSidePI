<?php

namespace App\Http;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public static function success(string $message, int $statusCode = 200, array $data = []): JsonResponse
    {
        $response = [
            'message' => $message,
            'data' => $data,
        ];

        return response()->json($response, $statusCode);
    }

    public static function error(string $message, int $statusCode): JsonResponse
    {
        $response = [
            'error' => $message,
        ];

        return response()->json($response, $statusCode);
    }
}
