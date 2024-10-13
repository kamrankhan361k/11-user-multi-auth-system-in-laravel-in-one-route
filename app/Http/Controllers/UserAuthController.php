<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{
    /**
     * Show the User login form.
     */
    public function showLoginForm()
    {
        return view('user.login');
    }

    /**
     * Handle User login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $credentials = $request->only('email', 'password');

        // Use Auth guard for user
        if (Auth::guard('user')->attempt($credentials)) {
            return redirect()->route('user.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    /**
     * Show the User registration form.
     */
    public function showRegisterForm()
    {
        return view('user.register');
    }

    /**
     * Handle User registration request.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        $data = $request->only('name', 'email', 'password');
        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()->route('user.login')->with('success', 'Registration successful, please login.');
    }

    /**
     * Handle User logout request.
     */
    public function logout()
    {
        Auth::guard('user')->logout();
        return redirect()->route('user.login');
    }

    /**
     * Show the User dashboard (protected route).
     */
    public function dashboard()
    {
        return view('user.dashboard');
    }
}
