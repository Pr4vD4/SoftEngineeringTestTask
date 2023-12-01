<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function profile()
    {
        return response()->json(new UserResource(Auth::user()));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(UserResource::collection(User::all()));
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
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|confirmed',
            'role_id' => 'exists:roles,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $userData = $validator->validated();

        $userData['password'] = Hash::make($request->password);

        $user = User::create($userData);

        return response()->json(new UserResource(User::find($user->id)));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return response()->json(new UserResource($user));
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
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'role_id' => 'exists:roles,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $taken_email = User::query()->where('email', $request->email)->first();

        if ($taken_email) {
            if ($taken_email->email != $user->email) {
                return response()->json([
                    'message' => 'The email has already been taken.'
                ], 400);
            }

        }

        $userData = $validator->validated();

        if (isset($request->password)) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        return response()->json(new UserResource($user));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'message' => 'success'
        ]);
    }
}
