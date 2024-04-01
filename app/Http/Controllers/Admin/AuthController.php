<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiResponse;

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $admin = Admin::where('email', $validated['email'])->first();

        if(!$admin)
        return $this->notFound('Account doesnot exist!');

        if(!Hash::check($validated['password'], $admin->password))
        return $this->unprocessed('Incorrect credential!');

        return $this->success('Login successful!', [
            'token' => $admin->createToken('adminToken')->plainTextToken
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->success('Logout successful!');
    }
}
