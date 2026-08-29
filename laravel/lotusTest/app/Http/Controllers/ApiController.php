<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    protected function successResponse($data, $message){
        return response()->json([
            'message' => $message,
            'data' => $data
        ]);
    }

    protected function loginResponse($data, $token, $message){
        return response()->json([
            'message' => $message,
            'data' => $data,
            'token' => $token
        ]);
    }
    
    protected function errorResponse($status, $message){
        return response()->json([
            'message' => $message,
        ], $status);
    }
}
