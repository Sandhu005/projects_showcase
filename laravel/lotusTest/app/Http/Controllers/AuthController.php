<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRegisterRequest $request)
    {
        $user = User::create($request->validated());

        return $this->successResponse($user, 'User has been registered!!');
    }
   
    public function login(UserLoginRequest $request)
    {
    
        $checkUser = User::where('email', $request->email)->get()->first();

        if($checkUser){
            if(Hash::check($request->password, $checkUser['password'])){
                $token = $checkUser->createToken('userToken')->plainTextToken;
                return $this->loginResponse($checkUser, $token, 'User Logged in');
            }else{
             return $this->errorResponse(400, 'Invalid Password!!');
            }
        }else{
            return $this->errorResponse(404, 'Invalid User!!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
