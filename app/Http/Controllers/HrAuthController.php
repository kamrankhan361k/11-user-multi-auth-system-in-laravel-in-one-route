<?php

namespace App\Http\Controllers;

use App\Models\Hr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HrAuthController extends Controller
{
    /**
     * Show the HR login form.
     */
    public function showLoginForm()
    {
        return view('hr.login');
    }

    /**
     * Handle HR login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $credentials = $request->only('email', 'password');

        // Use Auth guard for HR
        if (Auth::guard('hr')->attempt($credentials)) {
            return redirect()->route('hr.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    /**
     * Show the HR registration form.
     */
    public function showRegisterForm()
    {
        return view('hr.register');
    }

    /**
     * Handle HR registration request.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:hrs',
            'password' => 'required|min:8|confirmed',
        ]);

        $data = $request->only('name', 'email', 'password');
        $data['password'] = Hash::make($data['password']);

        Hr::create($data);

        return redirect()->route('hr.login')->with('success', 'Registration successful, please login.');
    }

    /**
     * Handle HR logout request.
     */
    public function logout()
    {
        Auth::guard('hr')->logout();
        return redirect()->route('hr.login');
    }

    /**
     * Show the HR dashboard (protected route).
     */
    public function dashboard()
    {
        return view('hr.dashboard');
    }
}
