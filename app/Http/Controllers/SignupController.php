<?php

// app/Http/Controllers/SignupController.php
namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class SignupController extends Controller
{
    public function showSignupForm($token)
    {
        $invite = Invitation::where('token', $token)->first();

        if (!$invite || $invite->expires_at < now()) {
            return redirect()->route('home')->withErrors('Invalid or expired token.');
        }

        return view('auth.signup', compact('invite'));
    }

    public function processSignup(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'password' => 'required|string|confirmed',
        ]);

        $invite = Invitation::where('token', $request->token)->first();

        if (!$invite || $invite->expires_at < now()) {
            return redirect()->route('home')->withErrors('Invalid or expired token.');
        }

        // Create user and assign as Admin
        $user = User::create([
            'name' => $validated['name'],
            'email' => $invite->email,
            'password' => Hash::make($validated['password']),
            'role' => 'admin',
            'team_id' => $invite->team_id,
        ]);

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}

