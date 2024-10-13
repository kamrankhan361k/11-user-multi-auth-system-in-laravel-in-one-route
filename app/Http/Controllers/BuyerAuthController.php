<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class BuyerAuthController extends Controller
{
    /**
     * Show the Buyer login form.
     */
    public function showLoginForm()
    {
        return view('buyer.login');
    }

    /**
     * Handle Buyer login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $credentials = $request->only('email', 'password');

        // Use Auth guard for Buyer
        if (Auth::guard('buyer')->attempt($credentials)) {
            return redirect()->route('buyer.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    /**
     * Show the Buyer registration form.
     */
    public function showRegisterForm()
    {
        return view('buyer.register');
    }

    /**
     * Handle Buyer registration request.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:buyers',
            'password' => 'required|min:8|confirmed',
        ]);

        $data = $request->only('name', 'email', 'password');
        $data['password'] = Hash::make($data['password']);

        Buyer::create($data);

        return redirect()->route('buyer.login')->with('success', 'Registration successful, please login.');
    }

    /**
     * Handle Buyer logout request.
     */
    public function logout()
    {
        Auth::guard('buyer')->logout();
        return redirect()->route('buyer.login');
    }

    /**
     * Show the Buyer dashboard (protected route).
     */
    public function dashboard()
    {
        return view('buyer.dashboard');
    }
}
