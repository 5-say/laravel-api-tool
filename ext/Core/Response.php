<?php

namespace Ext\Core;

use Illuminate\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;

class Response extends ResponseFactory
{
    /**
     * Return a new JSON response from the application.
     *
     * @param  string|array  $data
     * @param  int  $status
     * @param  array  $headers
     * @param  int  $options
     * @return \Illuminate\Http\JsonResponse
     */
    public function json($data = [], $status = 200, array $headers = [], $options = 0)
    {
        if ($data instanceof Arrayable && ! $data instanceof JsonSerializable) {
            $data = $data->toArray();
        }

        // IE9 flash 图片上传只能获取 200 状态码
        if (request('is-flash')) {
            $data['status'] = $status;
            $response = new JsonResponse($data, 200, $headers, $options);
        }
        else {
            $response = new JsonResponse($data, $status, $headers, $options);
        }

        return $response;
    }

}
