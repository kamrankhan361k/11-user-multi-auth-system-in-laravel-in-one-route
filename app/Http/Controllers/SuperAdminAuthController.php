<?php
namespace App\Http\Controllers;

use App\Models\SuperAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SuperAdminAuthController extends Controller
{
    /**
     * Show the Super Admin login form.
     */
    public function showLoginForm()
    {
        return view('superadmin.login');
    }

    /**
     * Handle Super Admin login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $credentials = $request->only('email', 'password');

        // Use Auth guard for superadmin
        if (Auth::guard('superadmin')->attempt($credentials)) {
            return redirect()->route('superadmin.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    /**
     * Show the Super Admin registration form.
     */
    public function showRegisterForm()
    {
        return view('superadmin.register');
    }

    /**
     * Handle Super Admin registration request.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:super_admins',
            'password' => 'required|min:8|confirmed',
        ]);

        $data = $request->only('name', 'email', 'password');
        $data['password'] = Hash::make($data['password']);

        SuperAdmin::create($data);

        return redirect()->route('superadmin.login')->with('success', 'Registration successful, please login.');
    }

    /**
     * Handle Super Admin logout request.
     */
    public function logout()
    {
        Auth::guard('superadmin')->logout();
        return redirect()->route('superadmin.login');
    }

    /**
     * Show the Super Admin dashboard (protected route).
     */
    public function dashboard()
    {
        return view('superadmin.dashboard');
    }
}
