<?php

namespace App\Http\Controllers;

use App\Models\It;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ItAuthController extends Controller
{
    /**
     * Show the IT login form.
     */
    public function showLoginForm()
    {
        return view('it.login');
    }

    /**
     * Handle IT login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $credentials = $request->only('email', 'password');

        // Use Auth guard for IT
        if (Auth::guard('it')->attempt($credentials)) {
            return redirect()->route('it.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    /**
     * Show the IT registration form.
     */
    public function showRegisterForm()
    {
        return view('it.register');
    }

    /**
     * Handle IT registration request.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:its',
            'password' => 'required|min:8|confirmed',
        ]);

        $data = $request->only('name', 'email', 'password');
        $data['password'] = Hash::make($data['password']);

        It::create($data);

        return redirect()->route('it.login')->with('success', 'Registration successful, please login.');
    }

    /**
     * Handle IT logout request.
     */
    public function logout()
    {
        Auth::guard('it')->logout();
        return redirect()->route('it.login');
    }

    /**
     * Show the IT dashboard (protected route).
     */
    public function dashboard()
    {
        return view('it.dashboard');
    }
}
