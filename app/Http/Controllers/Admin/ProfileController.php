<?php

namespace App\Http\Controllers\Admin;

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

        $admin = $request->user();

        $admin->update($validated);

        return $this->success('Profile has been updated!');
    }

    public function changePassword(Request $request)
    {
        $validated = $request->validate([
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required|same:new_password'
        ]);

        $admin = $request->user();

        if(!Hash::check($validated['old_password'], $admin->password))
        return $this->unprocessed('Incorrect credential!');

        $admin->password = $validated['new_password'];
        $admin->save();

        return $this->success('Password has been changed!');
    }
}
