<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Format JSON response
     *
     * @param array $data
     * @param int $code
     *
     * @return JsonResponse
     */
    public function jsonResponse(array $data, $code = 200): JsonResponse
    {
        return response()->json(array_merge($data, ['status_code' => $code]), $code);
    }

    /**
     * Respond with an Success
     *
     * @param mixed $data
     *
     * @return mixed
     */
    public function respondWithSuccess($data, $code = 200)
    {
        return $this->jsonResponse(is_array($data) ? $data : ['message' => $data], $code);
    }

    /**
     * Respond with an Error
     *
     * @param string $data
     * @param int $code
     *
     * @return JsonResponse
     */
    public function respondWithError($data = 'There was an error', $code = 400)
    {
        return $this->jsonResponse(is_array($data) ? $data : ['message' => $data], $code);
    }

}
