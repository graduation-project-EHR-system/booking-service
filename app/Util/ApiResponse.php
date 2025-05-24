<?php

namespace App\Util;

use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\AbstractPaginator;
use Symfony\Component\HttpFoundation\Response;

class ApiResponse
{
    public static function send($code = Response::HTTP_OK, $message = 'Success response', $data = [], $resource = null): JsonResponse
    {
        $response = [
            'status' => $code,
            'message' => $message,
            'data' => self::prepareData($data, $resource),
        ];

        return response()->json($response, $code);
    }

    public static function success(string $message = 'Success response', $data = [], $resource = null): JsonResponse
    {
        return self::send(Response::HTTP_OK, $message, $data, $resource);
    }

    public static function created(string $message = 'Resource created successfully', $data = [], $resource = null): JsonResponse
    {
        return self::send(Response::HTTP_CREATED, $message, $data, $resource);
    }

    public static function validationError(string $message, $errors, $resource): JsonResponse
    {
        return self::send(Response::HTTP_UNPROCESSABLE_ENTITY, $message, $errors, $resource);
    }

    protected static function getPaginationMeta(AbstractPaginator $paginator): array
    {
        return [
            'current_page' => $paginator->currentPage(),
            'per_page' => $paginator->perPage(),
            'total' => method_exists($paginator, 'total') ? $paginator->total() : null,
            'last_page' => method_exists($paginator, 'lastPage') ? $paginator->lastPage() : null,
        ];
    }

    protected static function prepareData($data, $resource)
    {
        if ($data instanceof AbstractPaginator && $resource != null) {
            $data = [
                'meta' => self::getPaginationMeta($data),
                'items' => $resource::collection($data->items()),
            ];
        }

        return $data;
    }
}
