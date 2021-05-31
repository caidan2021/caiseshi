<?php
/**
 * Created by IntelliJ IDEA.
 * Author: flashytime
 * Date: 2018/10/16 12:01
 */

namespace App\Support;

use Symfony\Component\HttpFoundation\Response;

trait ApiResponse
{
    /**
     * @param mixed $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function ok($data = [])
    {
        $code = 0;
        return $this->response(compact('data','code'), Response::HTTP_OK);
    }

    /**
     * @param int $code
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function response($data, $code = Response::HTTP_OK)
    {
        return response()->json($data, $code);
    }

    /**
     * @param $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function failed($message, $code = Response::HTTP_BAD_REQUEST)
    {
        return $this->response(['message' => $message, 'code' => $code]);
    }

    public function unOauth($message, $code = Response::HTTP_UNAUTHORIZED)
    {
        return $this->failed($message, $code);
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function internalError($message = "Internal Error")
    {
        return $this->failed($message, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function notFound($message = 'Not Found')
    {
        return $this->failed($message, Response::HTTP_NOT_FOUND);
    }
}
