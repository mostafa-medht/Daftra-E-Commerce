<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaginatedResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @return JsonResponse
     */
    public function sendResponse($result, $message, $code = 200): JsonResponse
    {
        $response = [
            'status' => true,
            'data'    => $result,
            'message' => $message,
        ];

        return response()->json($response, $code);
    }

    /**
     * success response method.
     *
     * @return JsonResponse
     */
    public function sendPaginatedResponse($result, $message, $code = 200): JsonResponse
    {
        $response = [
            'status' => true,
            'data'    => $result,
            'pagination' => $this->getPagination($result),
            'message' => $message,
        ];

        return response()->json($response, $code);
    }



    public function getPagination($result)
    {

        return PaginatedResource::make($result);
    }

    /**
     * return error response.
     *
     * @return JsonResponse
     */
    public function sendError($error, $errorMessages = [], $code = 422): JsonResponse
    {
        $response = [
            'status' => false,
            'message' => $error,
        ];


        if(!empty($errorMessages)){
            $response['errors'] = $errorMessages;
        }

        return response()->json($response, $code);
    }

    public function unauthorizedError(): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => 'This action is unauthorized.',
        ], 403);
    }

    public function errorMapper(array $errors): array
    {
        $newErrorMapperArray = array();

        foreach ($errors as $errorKey => $errorDescription){
            $newErrorMapperArray [] = [ 'field' => $errorKey , 'message' => $errorDescription];
        }

        return $newErrorMapperArray;
    }
}
