<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiResponse;

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fullname' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        ]);

        User::create($validated);

        return $this->success('Account creation successful!');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $validated['email'])->first();

        if(!$user)
        return $this->notFound('Account doesnot exist!');

        if(!Hash::check($validated['password'], $user->password))
        return $this->unprocessed('Incorrect credential!');

        return $this->success('Login successful!', [
            'token' => $user->createToken('userToken')->plainTextToken
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->success('Logout successful!');
    }
}
