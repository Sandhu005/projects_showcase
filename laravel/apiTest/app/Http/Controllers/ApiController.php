<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    protected function successResponse($data, $message = 'Success'){
        return response()->json([
            'message' => $message,
            'data' => $data
        ]);
    }
    
    protected function errorResponse($status, $message = 'error'){
        return response()->json([
            'message' => $message
        ], $status);
    }

    protected function loginResponse($data, $token){
        return response()->json([
            'message' => 'User Logged In!!',
            'data' => $data,
            'token' => $token
        ]);
    }
}
