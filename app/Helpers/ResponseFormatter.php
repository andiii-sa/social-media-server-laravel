<?php

namespace App\Helpers;

class ResponseFormatter
{
    protected static $response = [
        'data' => null,
        'meta' => [
            'code' => 200,
            'message' => null
        ],
    ];

    public static function success($data = null, $message = null)
    {
        self::$response['meta']['message'] = $message;
        self::$response['data'] = $data;

        return response()->json(self::$response, self::$response['meta']['code']);
    }

    public static function pagination($data = null, $message = null, $count, $offset, $limit)
    {
        self::$response['meta']['message'] = $message;
        self::$response['data'] = $data;
        if ($offset >= 0) {
            self::$response['meta']['offset'] = $offset;
        }
        if ($limit >= 0) {
            self::$response['meta']['limit'] = $limit;
        }
        if ($limit >= 0) {
            self::$response['meta']['total'] = $count;
        }

        return response()->json(self::$response, self::$response['meta']['code']);
    }

    public static function error($data = null, $message = null, $code = 400)
    {
        self::$response['meta']['code'] = $code;
        self::$response['meta']['message'] = $message;
        self::$response['data'] = $data;

        return response()->json(self::$response, self::$response['meta']['code']);
    }
}
