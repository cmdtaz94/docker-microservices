<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

trait Responser
{

    /**
     * @param mixed $responseData
     * @param int $responseStatusCode
     *
     * @return mixed
     */
    public function successResponse($responseData, $responseStatusCode = 200)
    {
        return response()->json($responseData, $responseStatusCode);
    }

    /**
     * @param mixed $errorMessage
     * @param int $errorStatusCode
     *
     * @return mixed
     */
    public function errorResponse($errorMessage, $errorStatusCode = JsonResponse::HTTP_INTERNAL_SERVER_ERROR)
    {
        return response()->json(['error' => $errorMessage, 'code' => $errorStatusCode], $errorStatusCode);
    }

}
