<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function profile()
    {
        $user = auth()->user();
        return view('profile', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
        ]);

        // update user
        Auth::user()->update($request->all());
        $user = Auth::user();

        return back()->with([
            'status' => 'Profile updated successfully!',
            'user' => $user
        ]);
    }
}
