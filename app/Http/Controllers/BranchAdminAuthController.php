<?php

namespace App\Http\Controllers;

use App\Models\BranchAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class BranchAdminAuthController extends Controller
{
    /**
     * Show the BranchAdmin login form.
     */
    public function showLoginForm()
    {
        return view('branchadmin.login');
    }

    /**
     * Handle BranchAdmin login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $credentials = $request->only('email', 'password');

        // Use Auth guard for BranchAdmin
        if (Auth::guard('branchadmin')->attempt($credentials)) {
            return redirect()->route('branchadmin.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    /**
     * Show the BranchAdmin registration form.
     */
    public function showRegisterForm()
    {
        return view('branchadmin.register');
    }

    /**
     * Handle BranchAdmin registration request.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:branch_admins',
            'password' => 'required|min:8|confirmed',
        ]);

        $data = $request->only('name', 'email', 'password');
        $data['password'] = Hash::make($data['password']);

        BranchAdmin::create($data);

        return redirect()->route('branchadmin.login')->with('success', 'Registration successful, please login.');
    }

    /**
     * Handle BranchAdmin logout request.
     */
    public function logout()
    {
        Auth::guard('branchadmin')->logout();
        return redirect()->route('branchadmin.login');
    }

    /**
     * Show the BranchAdmin dashboard (protected route).
     */
    public function dashboard()
    {
        return view('branchadmin.dashboard');
    }
}
