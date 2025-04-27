<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Handle a login request to the application.
     */
    public function authenticate(Request $request)
    {
        // Validate login form fields
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Attempt login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect to dashboard or homepage
            return redirect('/dashboard')->with('success', 'Logged in successfully.');
        }

        // If login fails, send back with error
        return back()->with('login_error', 'The provided credentials do not match our records.');
    }
}