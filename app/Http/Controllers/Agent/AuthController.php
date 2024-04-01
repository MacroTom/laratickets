<?php

namespace App\Http\Controllers\Agent;

use App\Models\Agent;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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

        $agent = Agent::where('email', $validated['email'])->first();

        if(!$agent)
        return $this->notFound('Account does not exist!');

        if(!Hash::check($validated['password'], $agent->password))
        return $this->unprocessed('Incorrect credential!');

        return $this->success('Login successful!', [
            'token' => $agent->createToken('agentToken')->plainTextToken
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->success('Logout successful!');
    }
}
