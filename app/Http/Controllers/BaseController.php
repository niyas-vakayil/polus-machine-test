<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    
    public function successResponse($data = [], $message)
    {
        
        return response()->json([
            'success'       => true,
            'data'          => $data,
            'message'       => $message,
            'status_code'   => 200
        ]);
    }

    
    public function errorResponse($message, $aErrors = [], $errorCode = "200")
    {
        return response()->json([
            'success'       => false,
            'data'          => [],
            'message'       => $message,
            'status_code'   => $errorCode
        ], $errorCode);
    }

   
    public function validationErrors($validator)
    {
        $allErrors = $validator->errors()->toArray();
        $aErrors = [];
        $errorMsg = '';
        foreach($allErrors as $field => $error) {
            $aErrors[$field] = implode(',', $error);
            $errorMsg.= implode(',',$error);
        }

        return response()->json([
            'status'        => false,
            'data'          => [],
            'message'       => $errorMsg,
            'status_code'   => 400
        ]);
    }

    
    public function serverError($error)
    {
        return response()->json([
            'success'       => false,
            'data'          => [],
            'message'       => $error,
            'status_code'   => 500
        ]);
    }
}