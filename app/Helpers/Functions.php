<?php

namespace App\Helpers;

class Functions {
    static function sendResponse($result, $message)
    {
        if ($message != ""){
    	$response = [
            'status' => 'ok',
            'data'    => $result,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }
        $response = [
            'status' => 'ok',
            'data'    => $result
        ];
        return response()->json($response, 200);
    }


    static function sendError($error, $errorMessages = [], $code = 404)
    {
    	$response = [
            'status' => 'failed',
            'message' => $error,
        ];
        if ($errorMessages != []) {
            if(!empty($errorMessages)){
                $response['data'] = $errorMessages;
            }
        }
        return response()->json($response, $code);
    }
}


