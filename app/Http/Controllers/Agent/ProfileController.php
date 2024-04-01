<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    use ApiResponse;

    public function update(Request $request)
    {
        $validated = $request->validate([
            'fullname' => 'required',
            'email' => 'required|email'
        ]);

        $agent = $request->user();

        $agent->update($validated);

        return $this->success('Profile has been updated!');
    }

    public function changePassword(Request $request)
    {
        $validated = $request->validate([
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required|same:new_password'
        ]);

        $agent = $request->user();

        if(!Hash::check($validated['old_password'], $agent->password))
        return $this->unprocessed('Incorrect credential!');

        $agent->password = $validated['new_password'];
        $agent->save();

        return $this->success('Password has been changed!');
    }
}
