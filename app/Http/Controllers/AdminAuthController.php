<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    /**
     * Show the Admin login form.
     */
    public function showLoginForm()
    {
        return view('admin.login');
    }

    /**
     * Handle Admin login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $credentials = $request->only('email', 'password');

        // Use Auth guard for admin
        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    /**
     * Show the Admin registration form.
     */
    public function showRegisterForm()
    {
        return view('admin.register');
    }

    /**
     * Handle Admin registration request.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins',
            'password' => 'required|min:8|confirmed',
        ]);

        $data = $request->only('name', 'email', 'password');
        $data['password'] = Hash::make($data['password']);

        Admin::create($data);

        return redirect()->route('admin.login')->with('success', 'Registration successful, please login.');
    }

    /**
     * Handle Admin logout request.
     */
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }

    /**
     * Show the Admin dashboard (protected route).
     */
    public function dashboard()
    {
        return view('admin.dashboard');
    }
}
