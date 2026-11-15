<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::withTrashed()->with('roles')->paginate(10);

        return view('users.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        $user = User::create($request->validated());

        $user->assignRole($request->role);

        return back()->with('success', 'User has been registered!!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = User::withTrashed()->with('roles')->findOrFail($id);

        return view('users.show', compact('data'));
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
    public function update(UserUpdateRequest $request, string $id)
    {

        $user = User::findOrFail($id);

        $user->update($request->validated());

        $user->assignRole($request->role);

        return redirect()->route('users.show', $id)->with('success', 'User has been updated!!');
    }

    /**
     * Restore blocked user.
     */
    public function restore(string $id)
    {
        $user = User::withTrashed()->findOrFail($id);

        $user->restore();
        $user->update([
            'status' => 'active',
        ]);

        return back()->with('success', 'User has been restored!!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'status' => 'inactive',
        ]);
        $user->delete();

        return back()->with('success', 'User has been deleted.');
    }
}
