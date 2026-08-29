<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash as Hash;

class UserController extends ApiController
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
    public function store(UserStoreRequest $request)
    {
        $newUser = new User();
        $newUser->name = $request->name;
        $newUser->email = $request->email;
        $newUser->password = Hash::make($request->password);

        $newUser->save();

        return $this->successResponse($newUser, 'User has been registered!!');
    }

    /**
     * Login Logic.
     */
    public function login(UserLoginRequest $request)
    {
        $checkUser = User::where('email', $request->email)->get()->first();

        if ($checkUser) {
            if ($checkUser['status'] == 'active') {
                if (Hash::check($request->password, $checkUser['password'])) {
                    $token = $checkUser->createToken('userToken')->accessToken;
                    return $this->loginResponse($checkUser, $token);
                } else {
                    return $this->errorResponse(400, 'Incorrect Password!!');
                }
            } else {
                return $this->errorResponse(400, 'Account has been blocked!');
            }
        } else {
            return $this->errorResponse(404, 'User not found!');
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
