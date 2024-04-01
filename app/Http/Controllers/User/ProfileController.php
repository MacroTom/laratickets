<?php

namespace App\Http\Controllers\User;

use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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

        $user = $request->user();

        $user->update($validated);

        return $this->success('Profile has been updated!');
    }

    public function changePassword(Request $request)
    {
        $validated = $request->validate([
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required|same:new_password'
        ]);

        $user = $request->user();

        if(!Hash::check($validated['old_password'], $user->password))
        return $this->unprocessed('Incorrect credential!');

        $user->password = $validated['new_password'];
        $user->save();

        return $this->success('Password has been changed!');
    }
}
