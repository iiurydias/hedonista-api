<?php

namespace App\Helpers;

class Functions {
    static function sendResponse($result, $message)
    {
        if ($message != ""){
    	$response = [
            'success' => true,
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
            'success' => false,
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


