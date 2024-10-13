<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class FinanceAuthController extends Controller
{
    /**
     * Show the Finance login form.
     */
    public function showLoginForm()
    {
        return view('finance.login');
    }

    /**
     * Handle Finance login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $credentials = $request->only('email', 'password');

        // Use Auth guard for Finance
        if (Auth::guard('finance')->attempt($credentials)) {
            return redirect()->route('finance.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    /**
     * Show the Finance registration form.
     */
    public function showRegisterForm()
    {
        return view('finance.register');
    }

    /**
     * Handle Finance registration request.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:finances',
            'password' => 'required|min:8|confirmed',
        ]);

        $data = $request->only('name', 'email', 'password');
        $data['password'] = Hash::make($data['password']);

        Finance::create($data);

        return redirect()->route('finance.login')->with('success', 'Registration successful, please login.');
    }

    /**
     * Handle Finance logout request.
     */
    public function logout()
    {
        Auth::guard('finance')->logout();
        return redirect()->route('finance.login');
    }

    /**
     * Show the Finance dashboard (protected route).
     */
    public function dashboard()
    {
        return view('finance.dashboard');
    }
}
